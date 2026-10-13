import test from 'node:test';
import assert from 'node:assert/strict';
import { chunks, parsePaths, summary } from '../action/preview-diff.mjs';

test('paths are parsed, deduped and chunked by 5', () => {
  assert.deepEqual(parsePaths('/ /a,/b  /a'), ['/', '/a', '/b']);
  assert.deepEqual(chunks([1, 2, 3, 4, 5, 6, 7], 5), [[1, 2, 3, 4, 5], [6, 7]]);
});

test('summary counts blockers and escapes table cells', () => {
  const s = summary([{ path: '/a|b', scoreBefore: 90, scoreAfter: 80, blockers: ['Title removed'], warnings: ['x'] }, { path: '/', scoreBefore: null, blockers: [], warnings: [] }], 'https://p.vercel.app', 'https://example.com');
  assert.equal(s.blockers, 1);
  assert.equal(s.warnings, 1);
  assert.match(s.md, /`\/a\/b`/);
  assert.match(s.md, /90 → 80/);
  assert.match(s.md, /No SEO changes/);
});
