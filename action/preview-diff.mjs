import { appendFileSync } from 'node:fs';
import { rpc, comment } from './seo-gate.mjs';

const MARK = '<!-- onpage-preview-diff -->';
const env = (k, d = '') => (process.env[k] ?? d).trim();
const wait = (ms) => new Promise((r) => setTimeout(r, ms));

export const chunks = (list, n) => Array.from({ length: Math.ceil(list.length / n) }, (_, i) => list.slice(i * n, i * n + n));
export const parsePaths = (s) => [...new Set(String(s).split(/[\s,]+/).map((p) => p.trim()).filter(Boolean))].slice(0, 25);

export function summary(pages, preview, production) {
  const blockers = pages.reduce((n, p) => n + p.blockers.length, 0);
  const warnings = pages.reduce((n, p) => n + p.warnings.length, 0);
  const icon = blockers ? '❌' : warnings ? '⚠️' : '✅';
  const cell = (s) => String(s).replace(/\|/g, '/').replace(/\n/g, ' ');
  return {
    blockers,
    warnings,
    md: [
      `### ${icon} OnPage.dev preview check: ${blockers} blocker(s), ${warnings} warning(s)`,
      `[Preview](${preview}) against [production](${production}).`,
      '',
      '| Path | Score | Findings |',
      '|---|---:|---|',
      ...pages.map((p) => `| \`${cell(p.path)}\` | ${p.scoreBefore == null ? '–' : `${p.scoreBefore} → ${p.scoreAfter}`} | ${[...p.blockers.map((x) => `**Blocker:** ${cell(x)}`), ...p.warnings.map((x) => `Warning: ${cell(x)}`)].join('<br>') || 'No SEO changes'} |`),
      '',
      'Compared as served HTML with [OnPage.dev](https://onpage.dev/mcp). The X-Robots-Tag noindex that preview hosts add is ignored.',
    ].join('\n'),
  };
}

async function main() {
  const preview = env('INPUT_PREVIEW_URL');
  const production = env('INPUT_PRODUCTION_URL');
  if (!/^https:\/\//.test(preview) || !/^https:\/\//.test(production)) {
    console.log('::error::Set preview-url and production-url to https addresses.');
    process.exit(1);
  }
  const failOn = env('INPUT_FAIL_ON', 'blocker');
  const token = env('INPUT_BYPASS_TOKEN');
  const init = await rpc({ id: 1, method: 'initialize', params: { protocolVersion: '2025-06-18', capabilities: {}, clientInfo: { name: 'onpage-preview-diff', version: '1.0.0' } } });
  const pages = [];
  for (const [i, part] of chunks(parsePaths(env('INPUT_PATHS', '/')), 5).entries()) {
    if (i) await wait(4000);
    const { json } = await rpc({ id: i + 2, method: 'tools/call', params: { name: 'compare', arguments: { mode: 'preview', preview_url: preview, production_url: production, paths: part, ...(token ? { bypass_token: token } : {}) } } }, init.session);
    const r = json?.result;
    if (!r || r.isError) throw new Error(r?.content?.[0]?.text || json?.error?.message || 'compare failed');
    pages.push(...r.structuredContent.pages);
  }
  const { blockers, warnings, md } = summary(pages, preview, production);
  console.log(md);
  if (process.env.GITHUB_STEP_SUMMARY) appendFileSync(process.env.GITHUB_STEP_SUMMARY, md + '\n');
  if (process.env.GITHUB_OUTPUT) appendFileSync(process.env.GITHUB_OUTPUT, `blockers=${blockers}\nwarnings=${warnings}\n`);
  await comment(md, MARK).catch((e) => console.log(`::warning::Comment failed: ${e.message}`));
  if ((failOn === 'blocker' && blockers) || (failOn === 'warning' && blockers + warnings)) {
    console.log(`::error::The preview has ${blockers} SEO blocker(s) and ${warnings} warning(s).`);
    process.exit(1);
  }
}

if (import.meta.url === `file://${process.argv[1]}`) main().catch((e) => {
  console.log(`::error::OnPage.dev preview check failed: ${e.message}`);
  process.exit(1);
});
