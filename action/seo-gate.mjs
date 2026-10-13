import { appendFileSync, readFileSync, readdirSync, statSync } from 'node:fs';
import { join, relative, sep } from 'node:path';

const MCP = process.env.ONPAGE_MCP_URL || 'https://onpage.dev/mcp';
const MARK = '<!-- onpage-seo-gate -->';
const env = (k, d = '') => (process.env[k] ?? d).trim();
const pattern = env('INPUT_PATHS', 'dist/**/*.html');
const base = env('INPUT_BASE_URL').replace(/\/+$/, '');
const min = Math.max(0, Math.min(100, Number(env('INPUT_MIN_SCORE', '80')) || 0));
const maxFiles = Math.max(1, Math.min(50, Number(env('INPUT_MAX_FILES', '10')) || 10));
const wait = (ms) => new Promise((r) => setTimeout(r, ms));

export function globToRegExp(glob) {
  let re = '';
  for (let i = 0; i < glob.length; i++) {
    const c = glob[i];
    if (c === '*' && glob[i + 1] === '*') {
      re += glob[i + 2] === '/' ? '(?:.*/)?' : '.*';
      i += glob[i + 2] === '/' ? 2 : 1;
    } else if (c === '*') re += '[^/]*';
    else if (c === '?') re += '[^/]';
    else re += c.replace(/[.+^${}()|[\]\\]/g, '\\$&');
  }
  return new RegExp(`^${re}$`);
}

export function findFiles(glob, root = '.') {
  const start = glob.split('/').filter((p, i, a) => !/[*?]/.test(p) && a.slice(0, i + 1).every((x) => !/[*?]/.test(x))).join('/') || '.';
  const re = globToRegExp(glob.replace(/^\.\//, ''));
  const out = [];
  const walk = (dir) => {
    let entries = [];
    try {
      entries = readdirSync(dir);
    } catch {
      return;
    }
    for (const name of entries.sort()) {
      if (name === 'node_modules' || name.startsWith('.')) continue;
      const path = join(dir, name);
      if (statSync(path).isDirectory()) walk(path);
      else if (re.test(relative(root, path).split(sep).join('/'))) out.push(path);
    }
  };
  const first = join(root, start);
  let isFile = false;
  try {
    isFile = statSync(first).isFile();
  } catch {}
  if (isFile) return re.test(relative(root, first).split(sep).join('/')) ? [first] : [];
  walk(first);
  return out;
}

export function urlFor(file, glob, baseUrl) {
  if (!baseUrl) return undefined;
  const root = glob.split('/').filter((p) => !/[*?]/.test(p)).slice(0, glob.split('/').findIndex((p) => /[*?]/.test(p))).join('/');
  let path = relative(root || '.', file).split(sep).join('/');
  path = path.replace(/(^|\/)index\.html$/, '$1').replace(/\.html$/, '');
  return `${baseUrl}/${path}`;
}

export async function rpc(body, session) {
  const res = await fetch(MCP, { method: 'POST', headers: { 'content-type': 'application/json', accept: 'application/json, text/event-stream', ...(session ? { 'mcp-session-id': session } : {}) }, body: JSON.stringify({ jsonrpc: '2.0', ...body }) });
  return { session: res.headers.get('mcp-session-id'), json: res.status === 202 ? null : await res.json() };
}

export async function comment(markdown, mark = MARK) {
  const token = env('INPUT_TOKEN');
  const event = process.env.GITHUB_EVENT_PATH ? JSON.parse(readFileSync(process.env.GITHUB_EVENT_PATH, 'utf8')) : {};
  if (!token || env('INPUT_COMMENT', 'true') !== 'true') return;
  const api = `${process.env.GITHUB_API_URL || 'https://api.github.com'}/repos/${process.env.GITHUB_REPOSITORY}`;
  const headers = { authorization: `Bearer ${token}`, accept: 'application/vnd.github+json', 'content-type': 'application/json' };
  const sha = event.deployment?.sha || event.check_run?.head_sha;
  const pr = event.pull_request?.number ?? (sha ? (await (await fetch(`${api}/commits/${sha}/pulls`, { headers })).json().catch(() => []))?.[0]?.number : undefined);
  if (!pr) return;
  const list = await (await fetch(`${api}/issues/${pr}/comments?per_page=100`, { headers })).json();
  const mine = Array.isArray(list) ? list.find((c) => String(c.body || '').includes(mark)) : null;
  const body = JSON.stringify({ body: `${mark}\n${markdown}` });
  const res = mine ? await fetch(`${api}/issues/comments/${mine.id}`, { method: 'PATCH', headers, body }) : await fetch(`${api}/issues/${pr}/comments`, { method: 'POST', headers, body });
  if (!res.ok) console.log(`::warning::Could not post the pull request comment (${res.status}). Give the workflow "pull-requests: write" permission.`);
}

async function main() {
  const files = findFiles(pattern).slice(0, maxFiles);
  if (!files.length) {
    console.log(`::error::No HTML files match "${pattern}". Run your build first or change the paths input.`);
    process.exit(1);
  }
  const init = await rpc({ id: 1, method: 'initialize', params: { protocolVersion: '2025-06-18', capabilities: {}, clientInfo: { name: 'onpage-seo-gate', version: '1.0.0' } } });
  const session = init.session;
  const rows = [];
  for (const [i, file] of files.entries()) {
    if (i) await wait(3200);
    const html = readFileSync(file, 'utf8');
    if (html.length > 900 * 1024) {
      rows.push({ file, error: 'larger than 900 KB, skipped' });
      continue;
    }
    const url = urlFor(file, pattern, base);
    const { json } = await rpc({ id: i + 2, method: 'tools/call', params: { name: 'scan_page', arguments: url ? { mode: 'html', html, url } : { mode: 'html', html } } }, session);
    const r = json?.result;
    if (!r || r.isError) rows.push({ file, error: r?.content?.[0]?.text || json?.error?.message || 'scan failed' });
    else rows.push({ file, score: r.structuredContent.score, ai: r.structuredContent.aiReadiness, fixes: r.structuredContent.fixes || [] });
  }
  const scored = rows.filter((r) => typeof r.score === 'number');
  const lowest = scored.length ? Math.min(...scored.map((r) => r.score)) : 0;
  const pass = scored.length > 0 && lowest >= min;
  const md = [
    `### ${pass ? '✅' : '❌'} OnPage.dev SEO gate: lowest score ${lowest} (minimum ${min})`,
    '',
    '| Page | Score | AI readiness | Fix first |',
    '|---|---:|---:|---|',
    ...rows.map((r) => (r.error ? `| \`${r.file}\` | – | – | ${r.error.replace(/\|/g, '/')} |` : `| \`${r.file}\` | ${r.score < min ? `**${r.score}**` : r.score} | ${r.ai ?? '–'} | ${r.fixes.slice(0, 3).map((f) => f.issue).join('; ').replace(/\|/g, '/') || 'Nothing'} |`)),
    '',
    `Scanned ${rows.length} of ${findFiles(pattern).length} file(s) with [OnPage.dev](https://onpage.dev/mcp). Link, image size and AI crawler checks need a live URL, so they run on the live site only.`,
  ].join('\n');
  console.log(md);
  if (process.env.GITHUB_STEP_SUMMARY) appendFileSync(process.env.GITHUB_STEP_SUMMARY, md + '\n');
  if (process.env.GITHUB_OUTPUT) appendFileSync(process.env.GITHUB_OUTPUT, `min-score=${lowest}\n`);
  await comment(md).catch((e) => console.log(`::warning::Comment failed: ${e.message}`));
  if (!pass) {
    console.log(`::error::SEO score ${lowest} is below the minimum of ${min}.`);
    process.exit(1);
  }
}

if (import.meta.url === `file://${process.argv[1]}`) main().catch((e) => {
  console.log(`::error::OnPage.dev SEO gate failed: ${e.message}`);
  process.exit(1);
});
