const MCP = process.env.ONPAGE_MCP_URL || 'https://onpage.dev/mcp';
const MARK = '<!-- onpage-fix-guard -->';
const env = (k, d = '') => (process.env[k] ?? d).trim();

export function broken(fixes) {
  return (fixes || []).filter((f) => ['undone', 'changed', 'gone'].includes(f.status));
}

export function issueBody(site, fixes, logId) {
  const rows = fixes.map((f) => `| ${f.url} | ${f.field} | ${f.status} | ${String(f.seen || '').replace(/\|/g, '\\|').slice(0, 80)} |`);
  const code = fixes.map((f) => `**${f.url}** (${f.field})\n\`\`\`html\n${f.restore || f.new}\n\`\`\``);
  return [
    MARK,
    `${fixes.length} SEO fix${fixes.length > 1 ? 'es' : ''} on ${site} ${fixes.length > 1 ? 'are' : 'is'} no longer live. A later deploy probably undid ${fixes.length > 1 ? 'them' : 'it'}.`,
    '',
    '| Page | Field | Status | Now on the page |',
    '| --- | --- | --- | --- |',
    ...rows,
    '',
    '### Restore',
    ...code,
    '',
    `Find where each value is set in this repo, put the value back and open a pull request. This issue closes itself once every fix is live again. Fix log \`${logId}\`, checked by [OnPage.dev](https://onpage.dev/mcp).`,
  ].join('\n');
}

async function getLog(id) {
  const res = await fetch(MCP, { method: 'POST', headers: { 'content-type': 'application/json', accept: 'application/json, text/event-stream' }, body: JSON.stringify({ jsonrpc: '2.0', id: 1, method: 'tools/call', params: { name: 'fix_log', arguments: { mode: 'report', fix_log_id: id, verify: true } } }) });
  const json = await res.json();
  if (json.error || json.result?.isError) throw new Error(json.error?.message || json.result?.content?.[0]?.text || 'get_fix_log failed');
  return json.result.structuredContent;
}

async function run() {
  const id = env('INPUT_FIX_LOG_ID');
  const token = env('INPUT_TOKEN');
  if (!id) throw new Error('Set fix-log-id (from log_fix).');
  const log = await getLog(id);
  const bad = broken(log.fixes);
  console.log(`${log.fixes.length} fixes logged, ${bad.length} no longer live.`);
  const api = `${process.env.GITHUB_API_URL || 'https://api.github.com'}/repos/${process.env.GITHUB_REPOSITORY}`;
  const headers = { authorization: `Bearer ${token}`, accept: 'application/vnd.github+json', 'content-type': 'application/json' };
  const label = env('INPUT_LABEL', 'seo-fix-guard');
  const open = await (await fetch(`${api}/issues?state=open&labels=${encodeURIComponent(label)}&per_page=50`, { headers })).json();
  const mine = Array.isArray(open) ? open.find((i) => String(i.body || '').includes(MARK)) : null;
  if (bad.length) {
    const body = JSON.stringify({ title: `SEO fixes undone on ${new URL(log.site).hostname}`, body: issueBody(log.site, bad, id), labels: [label] });
    const res = mine ? await fetch(`${api}/issues/${mine.number}`, { method: 'PATCH', headers, body }) : await fetch(`${api}/issues`, { method: 'POST', headers, body });
    if (!res.ok) console.log(`::warning::Could not write the issue (${res.status}). Give the workflow "issues: write" permission.`);
    if (env('INPUT_FAIL_ON_REGRESSION', 'false') === 'true') process.exitCode = 1;
  } else if (mine) {
    await fetch(`${api}/issues/${mine.number}/comments`, { method: 'POST', headers, body: JSON.stringify({ body: 'Every logged fix is live again. Closing.' }) });
    await fetch(`${api}/issues/${mine.number}`, { method: 'PATCH', headers, body: JSON.stringify({ state: 'closed' }) });
  }
  if (process.env.GITHUB_OUTPUT) {
    const { appendFileSync } = await import('node:fs');
    appendFileSync(process.env.GITHUB_OUTPUT, `undone=${bad.length}\n`);
  }
}

if (import.meta.url === `file://${process.argv[1]}`) run().catch((e) => { console.log(`::error::${e.message}`); process.exitCode = 1; });
