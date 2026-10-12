<p align="center">
  <a href="https://onpage.dev/mcp"><img src="assets/onpage-dev-banner.png" alt="OnPage.dev: free SEO and AI-visibility checks for AI assistants" width="720"></a>
</p>

<h1 align="center">OnPage.dev MCP server</h1>

<p align="center">
  <b>The SEO scanner your AI assistant uses to fix your site itself.</b><br>
  Scan, fix, check before deploy, confirm after. For Google and for AI search.
</p>

<p align="center">
  <a href="https://onpage.dev/mcp"><img alt="Hosted MCP server" src="https://img.shields.io/badge/MCP-hosted-4f46e5"></a>
  <img alt="Free, no API key" src="https://img.shields.io/badge/price-free%2C%20no%20key-0a7a43">
  <img alt="71 tools" src="https://img.shields.io/badge/tools-71-4f46e5">
  <a href="https://github.com/seoonpage/seo-mcp-server/actions/workflows/test.yml"><img alt="Tests" src="https://github.com/seoonpage/seo-mcp-server/actions/workflows/test.yml/badge.svg"></a>
  <a href="LICENSE"><img alt="MIT license" src="https://img.shields.io/badge/license-MIT-0b0b0f"></a>
</p>

<p align="center">
  <sub><b>Runs in</b></sub>&nbsp;&nbsp;
  <img src="assets/logos/claude.png" width="22" height="22" align="absmiddle" alt="">&nbsp;Claude&nbsp;&nbsp;&nbsp;
  <img src="assets/logos/chatgpt.png" width="22" height="22" align="absmiddle" alt="">&nbsp;ChatGPT&nbsp;&nbsp;&nbsp;
  <picture><source media="(prefers-color-scheme: dark)" srcset="assets/logos/cursor-dark.png"><img src="assets/logos/cursor.png" width="22" height="22" align="absmiddle" alt=""></picture>&nbsp;Cursor&nbsp;&nbsp;&nbsp;
  <img src="assets/logos/vscode.png" width="22" height="22" align="absmiddle" alt="">&nbsp;VS&nbsp;Code
  <br><br>
  <sub><b>Checks your site for</b></sub>&nbsp;&nbsp;
  <img src="assets/logos/chatgpt.png" width="22" height="22" align="absmiddle" alt="">&nbsp;ChatGPT&nbsp;&nbsp;&nbsp;
  <img src="assets/logos/claude.png" width="22" height="22" align="absmiddle" alt="">&nbsp;Claude&nbsp;&nbsp;&nbsp;
  <img src="assets/logos/gemini.png" width="22" height="22" align="absmiddle" alt="">&nbsp;Gemini&nbsp;&nbsp;&nbsp;
  <img src="assets/logos/perplexity.png" width="22" height="22" align="absmiddle" alt="">&nbsp;Perplexity&nbsp;&nbsp;&nbsp;
  <sub><b>Ships fixes to</b></sub>&nbsp;&nbsp;
  <img src="assets/logos/wordpress.png" width="22" height="22" align="absmiddle" alt="">&nbsp;WordPress
</p>

<p align="center">
  <a href="#install-in-one-minute">Install</a> ·
  <a href="#they-bring-the-data-onpagedev-closes-the-loop">Data vs results</a> ·
  <a href="#uses-the-seo-data-you-already-have">Your SEO data</a> ·
  <a href="#and-the-links-you-lost">Lost links</a> ·
  <a href="#the-whole-loop-inside-your-ai-agent">The whole loop</a> ·
  <a href="#from-finding-to-done">From finding to done</a> ·
  <a href="#seen-by-every-reader">Every reader</a> ·
  <a href="#real-user-speed">Real-user speed</a> ·
  <a href="#ships-as-a-pull-request">Pull requests</a> ·
  <a href="#keeps-watching-after-you-ship">Watch and alerts</a> ·
  <a href="#built-for-agents">Built for agents</a> ·
  <a href="#what-it-can-do">Tools</a> ·
  <a href="#why-it-is-different">Why it is different</a> ·
  <a href="#claude-code-plugin">Claude Code plugin</a> ·
  <a href="#github-action-seo-gate">GitHub Action</a> ·
  <a href="#github-action-fix-guard">Fix guard</a> ·
  <a href="https://onpage.dev">onpage.dev</a>
</p>

---

Most SEO tools give you a report. OnPage.dev gives your assistant something to **do**: write the fix, check it before you publish, and confirm it worked. It also checks what AI search sees, not only Google: which AI crawlers may read your site, whether your content is ready to be quoted, and whether you have an `llms.txt`.

```
You:        Fix the SEO on our pricing page and keep going until it scores 90 or more.

Assistant:  scan_page            46/100  no meta description, no H1, title 14 characters
            get_fix_pack         title, description and canonical, written from the page
            generate_schema      Product JSON-LD, 2 values to fill in
            (edits pricing.html)
            scan_html            92/100  before deploying, all errors gone
            rescan_and_compare   94/100  live, +48 since the first scan

            Done. 46 to 94. Two prices in the JSON-LD still need your real values.
```

## They bring the data. OnPage.dev closes the loop.

The SEO MCP servers from Ahrefs, Semrush, SE Ranking and DataForSEO are built for data: what ranks, who links, what people search. Then the real work starts. OnPage.dev does that part, inside the same chat, and uses their numbers to decide what to fix first.

<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="assets/loop-dark.png">
    <img src="assets/loop-light.png" width="720" alt="Step 1, data from Ahrefs, Semrush, SE Ranking or DataForSEO, is passed to OnPage.dev, which takes over: 2 find, 3 fix, 4 check, 5 ship, 6 notify, 7 prove. The results flow back into your data and the loop starts again.">
  </picture>
</p>

<table>
  <tr><th align="left">Step</th><th align="left"><img src="assets/logos/onpage.png" width="26" height="26" alt=""><br>OnPage.dev</th><th align="left"><img src="assets/logos/ahrefs.png" width="22" height="22" alt="">&nbsp;&nbsp;<img src="assets/logos/semrush.png" width="22" height="22" alt="">&nbsp;&nbsp;<img src="assets/logos/seranking.png" width="22" height="22" alt="">&nbsp;&nbsp;<img src="assets/logos/dataforseo.png" width="22" height="22" alt=""><br>Data MCPs</th></tr>
  <tr><td><b>Search data: rankings, keywords, backlinks</b></td><td>✅ Uses yours, from Search Console, GA4, Ahrefs or Semrush in the same chat</td><td>Their core strength</td></tr>
  <tr><td><b>Find what is wrong on the page</b></td><td>✅ <code>scan_page</code>, <code>deep_audit</code>, <code>render_page</code>: Google, AI search, speed, accessibility</td><td>Site audit data in some of them</td></tr>
  <tr><td><b>Write the fix from the page itself</b></td><td>✅ <code>get_fix_pack</code>, <code>generate_schema</code></td><td><i>Not what they are built for</i></td></tr>
  <tr><td><b>Ship it where the code lives</b></td><td>✅ Yoast SEO and Rank Math fields, or a Git pull request for Next.js, Nuxt, SvelteKit, Astro, Angular, React or Vue</td><td><i>Not what they are built for</i></td></tr>
  <tr><td><b>Check it before deploy</b></td><td>✅ <code>scan_html</code> and <code>compare_html</code> on unpublished HTML</td><td><i>Not what they are built for</i></td></tr>
  <tr><td><b>Tell search engines</b></td><td>✅ <code>submit_indexnow</code>, plus URL Inspection through your Search Console</td><td><i>Not what they are built for</i></td></tr>
  <tr><td><b>Cover the AI Mode fan-out</b></td><td>✅ <code>check_question_coverage</code>: every sub-question answered, buried or missing</td><td><i>Not what they are built for</i></td></tr>
  <tr><td><b>Prove the result</b></td><td>✅ <code>measure_impact</code>: before and after, against pages you did not touch</td><td>Their numbers are the input</td></tr>
  <tr><td><b>Price to start</b></td><td>✅ <b>Free.</b> No account, no API key</td><td>A paid plan or prepaid credits</td></tr>
</table>

<table>
  <tr><th align="left">Same question to a data MCP</th><th align="left">Same question to OnPage.dev</th></tr>
  <tr>
    <td valign="top"><pre>/pricing ranks #14
"seo tool pricing": 1.2k a month
3 referring domains
Top 3 results: 40+ each</pre>Useful facts. The next step is yours.</td>
    <td valign="top"><pre>Title cut off, no canonical
Pricing section skips the answer
Fix in Next.js, checked: 58 → 91
Pull request #42 opened
IndexNow sent
4 weeks: +38% clicks (others +4%)</pre>Closed, from finding to result.</td>
  </tr>
</table>

<sub>An example of the two kinds of answer. Prices, plans and the full comparison: <a href="https://onpage.dev/compare">onpage.dev/compare</a>. Built by an SEO specialist with 24 years of experience; the scoring method is public at <a href="https://onpage.dev/methodology">onpage.dev/methodology</a>.</sub>

## The whole loop, inside your AI agent

Most SEO tools stop at a report. OnPage.dev gives an agent every step, and each step is a tool it can call:

| Step | What happens | Tools |
|---|---|---|
| **Find** | What is wrong for Google, AI search, phones and screen readers, ranked by the traffic it can win | `scan_page`, `start_site_audit`, `render_page`, `screen_reader_view`, `prioritize_fixes`, `match_intent`, `check_readability` |
| **Fix** | Ready code from the page's own content, shipped as a pull request, through WordPress or at the edge with a Cloudflare Worker on any CMS | `get_fix_pack`, `generate_schema`, `ai_crawler_policy`, `plan_redirects`, `fix_broken_backlinks` |
| **Check** | The new HTML and JSON-LD tested before deploy, then confirmed live | `scan_html`, `validate_schema`, `compare_html`, `rescan_and_compare` |
| **Act** | Every shipped fix logged with its old and new value, and the plan sent to Google Sheets, Slack, Notion or the task board | `log_fix`, `export_findings`, `share_result` |
| **Watch** | Every logged fix checked about every 6 hours, with the restore code sent to your webhook when a deploy undoes one | `get_fix_log`, `watch_page` |
| **Measure** | Clicks, AI citations and real-user speed before and after, against pages you did not touch, saved per fix with a rollback plan and a client report. Plus why traffic dropped, page-1 results nobody clicks and queries almost on page 1 | `measure_impact`, `measure_ai_citations`, `check_vitals_trend`, `diagnose_traffic_drop`, `find_ctr_gaps`, `find_striking_distance`, `get_fix_log` |

```
Four weeks later...

You:        Did the fixes on /pricing and /features work?

Assistant:  (Search Console)     clicks for 28 days before and after 8 September
            measure_impact       changed pages +70%, unchanged pages +3%
                                 → +66% lift; /features +357% after the stray noindex was removed
```

`measure_impact` subtracts the trend of the pages you did not change, so seasonality and Google updates are not counted as your result. It is honest about what it shows: a comparison of two periods, not proof.

## From finding to done

Most SEO tools stop at a report. OnPage.dev hands the plan to the tools your team already works in, so fixes get assigned and shipped. `export_findings` turns a page scan or a whole site audit into:

- **Google Sheets**: one row per finding with priority, page, issue, fix, code and status. Every export comes with a private CSV link, so `=IMPORTDATA("https://onpage.dev/export/….csv")` loads it into a sheet with **no connector at all**.
- **Slack, Teams or Discord**: a ready summary with the fixes that matter most, posted by the agent's Slack tool or straight to an incoming webhook.
- **Linear, Jira, Asana, Trello or GitHub Issues**: one task per issue, grouped across pages, with priority, labels and how to fix it.
- **Notion or Confluence**: a Markdown checklist.

```
You:        Audit example.com, put every fix in a Google Sheet and post the summary in #seo.

Assistant:  start_site_audit     25 pages, 41 findings
            export_findings      sheet link, Slack message, 12 tasks
            (Google Sheets)      rows added to "SEO fixes"
            (Slack)              posted to #seo
```

OnPage.dev never logs in to Slack, Google or your task board: the agent sends the plan with the tools the user already connected, or you paste one formula. Scan results and audits end with a hint, so agents offer the export on their own.

## Seen by every reader

Google reads your HTML. Visitors see one screen on a phone. Screen readers, and AI agents that browse for people, read the accessibility tree. OnPage.dev checks all three in a real browser.

**`render_page`** loads the page on a phone, tablet and desktop and checks the first screen: is the H1 and the call to action visible without scrolling, does a cookie wall or pop-up cover it, are tap targets big enough, what shifts while loading. It loads the page again with JavaScript off to show what GPTBot and ClaudeBot miss, and checks whether the first screen delivers what the Google snippet promises. With screenshots.

It also checks **design and readability**, the details that make a page look professional and easy to read:

- Text with too little contrast, measured against its real background (WCAG AA: 4.5:1, or 3:1 for large text), with the colours to fix.
- The exact element that makes the page scroll sideways on a phone, and by how many pixels.
- Mixed button styles: how many corner styles and heights the buttons use.
- Uneven spacing between sections.

**`screen_reader_view`** reads the page the way a screen reader announces it:

```
heading level 1, Running shoes for flat feet
link, Women
link                         ← announced without a name
button                       ← announced without a name
image, Trail shoe in grey mesh, side view
link, Read more              ← vague, and weak anchor text
```

It flags links and buttons without a name, vague link text, form fields without a label, a missing main landmark, skipped headings and visible text hidden from readers. Accessibility is not a direct Google ranking factor, but alt text, link text, headings and text that is not hidden are exactly what search engines, AI answer engines and browsing agents read. Even carefully built sites miss this, including sites built with AI coding assistants. In a real scan of a well-built news site that passed every other check, including Lighthouse, the screen reader view still caught links announced as just "link" in nine different card layouts across the site: each thumbnail image linked to its article but gave a screen reader no name to read.

Have your own browser tool (Claude in Chrome, Playwright)? **`get_layout_probe`** gives a small measurement script and **`analyze_layout`** analyses its results: no daily limit, and it works on staging, localhost and pages behind a login.


## Real-user speed

Lab tests guess. **`check_web_vitals`** shows what real Chrome visitors got over the last 28 days, from the Chrome UX Report: the field data Google uses for ranking.

```
You:        Is our homepage fast enough for Google?

Assistant:  check_web_vitals     Phone: passed · Desktop: passed
                                 LCP  1.4 s   good   93% of visits good
                                 INP  197 ms  good   75% of visits good, 8% poor
                                 CLS  0.00    good   95% of visits good
```

- LCP, INP and CLS, plus FCP and time to first byte, on phone and desktop, each rated good, needs improvement or poor.
- Pass or fail on the Core Web Vitals assessment, and the share of visits that were good, needs work or poor.
- Pages with too little traffic fall back to the whole site, and the tool says so.
- What to fix for every metric that is not good. The same card is in every scan on [onpage.dev](https://onpage.dev).
## Uses the SEO data you already have

Already connected Google Search Console, GA4, Ahrefs or Semrush to your assistant? OnPage.dev tells the assistant to pull their numbers in, then `prioritize_fixes` ranks every fix by the traffic it can win. Nothing connected? It ranks by severity, as before. You do not set anything up.

```
You:        Audit example.com and tell me what to fix first.

Assistant:  start_site_audit     10 pages, average 81
            (Ahrefs) top pages   clicks, positions, keywords, referring domains
            prioritize_fixes     ranked by traffic impact

            1. /pricing is noindex but gets 900 visits a month. Fix this first.
            2. /results ranks #6 for "league table" (5,600 searches a month).
               Add the term to the H1 to push into the top 3, ~330 extra clicks.
            3. /guide shows up 20,000 times at position 3 but gets 0.2% clicks.
               Rewrite the title and description, test them with check_snippet.
```

How it works: an MCP server cannot read other connectors, and should not. OnPage.dev's results and instructions ask the assistant to fetch the numbers from any SEO data tool it has, and the assistant passes them to `prioritize_fixes`. The numbers are used for that answer only and never stored. OnPage.dev never logs in to those services.

### And what AI already cites

With Ahrefs Brand Radar (or any source of AI citation counts) connected, `compare_ai_citations` puts the pages ChatGPT, Perplexity, Gemini and Google AI cite next to the ones they skip. OnPage.dev scans every page and shows which checks the cited pages pass and the others fail, the averages side by side (AI readiness, words, facts per 100 words, outside sources, entity graph issues), and what each skipped page should change. It is honest about the limits: a correlation over a few pages, not proof of cause.

What `prioritize_fixes` looks for: blockers on pages with traffic, low click-through for the position, keywords in striking distance (position 4 to 15), top queries missing from the title or H1, and pages with strong backlinks that score badly.

With GA4 conversions (key events) or revenue per page, it ranks by money instead of clicks: a pricing page that converts comes before a busy blog post that does not.

### And the links you lost

Other sites still link to pages you deleted or moved. Every one of those links is value you no longer get. With Ahrefs, Semrush or a CSV export, `fix_broken_backlinks` turns them back into ranking power:

```
You:        Which of our backlinks point at dead pages? Fix them.

Assistant:  (Ahrefs) broken backlinks   112 links to 19 dead pages
            fix_broken_backlinks        ranked by linking sites and domain rating
                                        top 20 checked live: 14 dead, 3 already fixed, 2 block bots

            1. /blog/running-shoes-guide  38 sites, best DR 81  → /guides/running-shoes
            2. /old-promo                 12 sites, best DR 64  → /socks/trail (anchor text match)
            3. /moved                     reached via 3 redirects → one 301 straight to /new-home
            14 rules ready for _redirects. /old-promo is still in your sitemap.
```

The dead pages are grouped and ranked by link value (each linking site counts once, weighted by domain rating, nofollow at 30%). The top 20 are checked live, so pages that already work again or only block bots are not redirected by mistake. Each dead page gets the best live page from your sitemap or a site audit, matched on the URL, the page title and the anchor texts other sites used. No close match? It says so instead of dumping the link on the home page. The rules come out for `_redirects`, nginx, Apache, Next.js or CSV, with the strongest linking sites worth an email. Then `check_urls` confirms each one is a single 301 and `log_fix` keeps watching them.

## Matches search intent

The fastest way to waste a month: write a product page for a keyword where Google only ranks guides. `match_intent` checks what actually ranks before you write.

Your agent pulls the top results for the keyword from Ahrefs or Semrush, and OnPage.dev scans every one of them and works out the page type Google rewards: guide, listicle or comparison, product page, category page, service page, tool, local business page, news article, recipe, help page, pricing page, forum or video.

```
You:        Does our page fit "best running shoes for flat feet"?

Assistant:  (Ahrefs) serp-overview   top 7 results
            match_intent             8 pages read

            Your page fits: Google ranks listicles here (runrepeat, rtings),
            and yours is one too.
            4 of 7 results are forums (Reddit, JustAnswer): searchers want
            real experience. Add first-hand testing, photos and named experts.
            43% of the top results put the year in the title.
```

- **Page type match:** match, close (same intent, other format) or mismatch, with the evidence per result.
- **Format that ranks:** median length and subheadings of the top results, how many have a FAQ, a year or a number in the title.
- **Forums and videos:** recognised from the address, without scraping them, and turned into concrete advice about experience and trust.
- **The whole site:** pass Search Console rows and it finds queries where two of your pages compete with each other, and pages that attract mixed intents.

### Readability that fits the page

A product page should not read like documentation. `check_readability` measures reading ease (Flesch, or Flesch-Douma for Dutch) against the right target: the median of the pages that rank for the keyword, or the common norm for the page type when there are no competitors. It lists the hardest sentences and paragraphs to rewrite first, ignoring menus, link lists and tables.

```
Assistant:  check_readability   Reading ease 63, ranking pages median 52 (52, 63, 49)
            Hardest sentence (22 words, score 8):
            "Runner's World Running Reviews Editor, Amanda Furrer, who has
             relatively low arches, researched shoe testing data from..."
```

## Ships to WordPress

From chat to live, with you approving every change. `get_fix_pack` with `platform: "wordpress"` turns the fixes into a WordPress plan your agent can apply through your own WordPress connection (for example a WordPress MCP server):

```
You:        Fix the SEO on /trail-shoes and put it live.

Assistant:  scan_page            46: title too short, no meta description, 1 image without alt
            get_fix_pack         platform: wordpress, 3 changes
                                 SEO title       -> Yoast _yoast_wpseo_title
                                 Description     -> Yoast _yoast_wpseo_metadesc
                                 Alt text        -> media library

            Shall I apply these 3 changes?          You: yes
            (WordPress) update post + media
            rescan_and_compare   94, all 3 fixed
```

- The exact field for each value in Yoast SEO and Rank Math, alt texts for the media library, and structured data as a Custom HTML block.
- Your agent shows every change as old and new value and waits for your approval before anything goes live.
- OnPage.dev never logs in to your site and stores no passwords: your own WordPress connection makes every change.
- Without a WordPress connection, the same plan tells you exactly what to paste where.

## Ships as a pull request

Not on WordPress? `get_fix_pack` with `platform: "git"` writes the fixes as code for the site's framework and opens a pull request through the git tools your agent already has. It detects Next.js (App and Pages Router), Nuxt, SvelteKit, Astro, Angular, React, Vue and plain HTML from the page itself.

```
You:        Fix the SEO on /pricing and open a PR.

Assistant:  scan_page            58: title too short, no canonical, no structured data
            get_fix_pack         platform: git, detected Next.js (App Router)
                                 export const metadata = { title, alternates.canonical }
                                 JSON-LD in the page component
            git switch -c seo/onpage-pricing
            (edit app/pricing/page.tsx, build)
            scan_html            91, nothing else changed
            gh pr create         #42 "SEO: title, canonical, jsonLd for /pricing"
```

- `metadata` for Next.js, `useSeoMeta` and `useHead` for Nuxt and Vue, `<svelte:head>` for SvelteKit, the `Title` and `Meta` services for Angular, head tags for Astro and plain HTML.
- Always a new branch, checked with `scan_html` before the PR, never merged by the agent.
- For client-side React, Vue and Angular apps it also says how to prerender, because AI crawlers do not run JavaScript.

## Share cards, with a free API

`check_og_tags` shows how a page looks when it is shared on Facebook, LinkedIn, X, WhatsApp and Slack: every Open Graph and Twitter tag, and the share image itself. It loads the image and reads its real size from the file header, so it catches the cases other checkers miss: an `og:image` that returns 404, a 400 x 400 logo where a 1200 x 630 image belongs, an SVG that no platform shows, or a 6 MB file.

The same check is a free public REST API, no key needed:

```bash
curl "https://onpage.dev/api/v1/og?url=https://example.com"
```

```json
{ "url": "https://github.com/", "score": 100,
  "image": { "ok": true, "type": "image/png", "width": 1200, "height": 630, "bytes": 618778 },
  "issues": [] }
```

10 requests a minute per IP address, CORS open, each result cached for 5 minutes. Try it in the browser: [Open Graph checker](https://onpage.dev/tools/og-checker).

## Keeps watching after you ship

Most SEO problems are not there on launch day. They arrive later: a deploy adds `noindex`, a CMS update changes the canonical, a new robots.txt blocks GPTBot. `watch_page` rechecks a page about once a day and records every change for search and AI. Alerts go to a private RSS feed and, if you give one, a Slack or Discord webhook. No account, no key.

```
You:        Keep an eye on our pricing page and tell me if anything breaks.

Assistant:  watch_page           baseline 94/100, 8 of 8 AI crawlers allowed
            ...three days later, in your Slack:
            OnPage.dev: 2 change(s) on https://example.com/pricing
            - A noindex tag was added: the page will drop out of Google
            - The score went from 94 to 71
```

And three more jobs agents get asked to do every week:

- **`create_content_brief`**: give a search term and the pages that rank, get a writing brief: the subtopics most of them cover, the questions they answer, figures to back up with your own data, a target length, schema and internal links. Bot walls and navigation headings are filtered out.
- **`plan_redirects`**: give the old and new URLs (or the sites, to read their sitemaps) and get a 301 map with a confidence score per match, written as `_redirects`, nginx, Apache, Next.js or CSV. Then verify after launch with `check_urls`.
- **`fix_broken_backlinks`**: pass the broken backlinks from Ahrefs, Semrush or a CSV export. The dead pages are ranked by the sites that still link to them, the top 20 are checked live, each gets the best live page to 301 to (from the sitemap, a site audit and the anchor texts), and the rules come out ready to ship. Dead pages still in the sitemap, redirect chains and temporary redirects are flagged too.
- **`share_result`**: after fixing a site, publish a before and after page (for example 46 → 94, with the issues fixed) to send to your client. Not indexed, expires after 90 days.

## Built for agents

What makes OnPage.dev different from every other SEO MCP server:

- **Everything in one chat, dashboards included.** Data, plan, the fix your agent deploys and the proof all happen in the chat. `create_dashboard_feed` checks a site's key pages every day, `get_dashboard_data` returns the history as clean tables that join with GA4 and Search Console, and `build_seo_dashboard` designs a live dashboard for Claude with a realtime GA4 block (active users per minute, pages, events) next to SEO health, fixes, speed and AI visibility.
- **Takes action, not notes.** Your agent ships the fix itself: a pull request in your framework, a change through your own WordPress connection, or a Cloudflare Worker from `get_fix_pack` with `platform: "cloudflare"` that corrects the tags as the page is served, on any CMS on your own Cloudflare account. One step to roll back.
- **Closes the loop for real.** `log_fix` records every fix that shipped. OnPage.dev checks about every 6 hours that each one is still live, sends the restore code to your webhook when a deploy undoes it, saves `measure_impact` results per fix with a rollback plan when one did worse, and `get_fix_log` writes the client report.
- **Proves the result.** `measure_impact` compares before and after numbers against a control group of unchanged pages. [More](#the-whole-loop-inside-your-ai-agent).
- **From finding to done.** `export_findings` sends the plan to Google Sheets (no connector needed), Slack, Notion or a task board. [More](#from-finding-to-done).
- **Sees every reader.** First screen on phone, tablet and desktop in a real browser, and the page read aloud like a screen reader. [More](#seen-by-every-reader).
- **Handles JavaScript apps.** Pure client-side React, Angular and Vue apps get a full audit of the rendered page, the way Google sees it, plus how little AI crawlers get without JavaScript.
- **Ships anywhere.** WordPress through your own connection, every other stack as a Git pull request with framework code. [More](#ships-as-a-pull-request).
- **Real users and real bots.** `check_web_vitals` reads Core Web Vitals from real Chrome users; `analyze_logs` shows what Googlebot and AI crawlers actually crawl.
- **Multilingual and trustworthy.** `check_hreflang` checks every language version and writes the corrected tag set; `check_trust_signals` checks the E-E-A-T signals across the whole site.
- **No gaps in the technical audit.** `check_sitemap` checks format, limits and lastmod dates and samples the listed URLs for redirects, errors, noindex and canonicals elsewhere. `extract_from_pages` pulls one value from up to 20 pages (CSS selector, regex or JSON-LD path). `find_duplicate_content` groups near-duplicate pages from an audit by their own content, and `check_url_parameters` finds tracking, search and filter URLs that trap crawlers.
- **Measures more than clicks.** `diagnose_traffic_drop` explains a drop page by page (lost rankings, lower demand, fewer clicks at the same position, pages that dropped out), `find_ctr_gaps` and `find_striking_distance` find the fastest wins in Search Console data, `check_vitals_trend` shows real-user speed weekly for about 9 months before and after a fix, and `measure_ai_citations` proves the gains in AI answers against a control group.
- **Fixes a whole section, and JavaScript apps.** `build_edge_rules` turns a site audit into one Cloudflare Worker rule per section (titles, descriptions, canonicals, social tags on every matching page, with a preview). `get_prerender_worker` serves GPTBot, ClaudeBot and PerplexityBot the rendered page of a React, Vue or Angular app from Browser Rendering in your own Cloudflare account.
- **Explains why Google skips a page.** `explain_index_status` turns Search Console URL Inspection results into causes, fixes and the next tool, and every scan catches a head that ends early (an image or iframe in `<head>` that hides the canonical).
- **Watches your competitors.** `watch_page` with `competitor_of` follows a competitor's page; when they add a section, structured data or a lot more text, the alert says what your page is missing and which tool fixes it.
- **Every fix in your GA4 charts and your repo.** `get_fix_log` with `format: "annotations"` marks each fix day in GA4, and the [fix guard](#github-action-fix-guard) GitHub Action opens an issue with the restore code when a deploy undoes a fix.
- **Debugs your GA4.** `check_ga4_tracking` captures the hits a page really sends to Google in a real browser, before and after accepting cookies and on a return visit: double counting, tracking before consent, a banner that never updates Consent Mode, debug mode left on, Universal Analytics leftovers.
- **Makes AI read and quote you.** `ai_crawler_policy` writes robots.txt rules for 13 AI crawlers, `generate_llms_txt` and `validate_llms_txt` handle llms.txt, `find_answer_passages` shows whether a page answers well enough to be quoted, `check_entity_graph` checks that AI knows who is behind the site.
- **Maps your topics and wins the snippet.** `map_topics` groups Search Console queries into topics with the page that owns each one, competing pages and gaps; `check_answer_format` shows the answer format (paragraph, list or table) that wins the featured snippet.
- **Matches what ranks.** `match_intent` finds the page type Google rewards for a keyword, `check_readability` compares reading ease with the pages that rank, and `create_content_brief` turns them into a writing brief.
- **Share previews that work.** `check_og_tags` loads the real share image and checks it against Facebook, LinkedIn and X, also as a free REST API.
- **Local and linked.** `check_local_seo` checks LocalBusiness markup, NAP consistency, the Google Business Profile link and a page per location; `map_link_equity` maps internal PageRank and click depth and shows which important pages need more links.
- **Ready for AI Mode.** `check_question_coverage` checks a page against the sub-questions AI search fans out for a topic, and shows the gaps where AI will cite someone else.
- **Accessibility for the EAA.** `check_accessibility` maps every check to WCAG 2.1 AA, the standard behind the European Accessibility Act.
- **Ecommerce and consent.** `check_product_page` checks Product markup for merchant listings; `check_consent` checks the cookie banner and Consent Mode v2.
- **Closes the loop after shipping.** `submit_indexnow` pings Bing and other IndexNow engines, and the agent runs URL Inspection in your Search Console tool for Google.
- **Reads every language right.** Reading ease uses the formula for the page language: Flesch-Douma for Dutch, Amstad for German, Kandel-Moles for French, Fernández-Huerta for Spanish.
- **A public scoring method.** Every check, what it costs and what the score leaves out, on [onpage.dev/methodology](https://onpage.dev/methodology). What changed lives on [onpage.dev/changelog](https://onpage.dev/changelog).
- **Light on context.** Connect `https://onpage.dev/mcp?tools=core` for the 10 main tools when your agent already loads many servers.
- **Keeps watching.** `watch_page` catches regressions after launch and alerts by RSS or webhook. [More](#keeps-watching-after-you-ship).
- **Uses the data you already have.** Search Console, GA4, Ahrefs or Semrush in the same chat? `prioritize_fixes` ranks every fix by traffic impact with their numbers, and `compare_ai_citations` shows what the pages AI cites do differently. [How it works](#uses-the-seo-data-you-already-have).
- **Stable issue codes and typed results.** Every issue has a fixed code like `meta-missing` or `h1-missing`, and the main tools declare an output schema. An agent can work through issues one by one and prove each one is gone.
- **It checks the code the agent writes.** `scan_html`, `validate_schema` and `compare_html` test new HTML and JSON-LD before it ships, and catch regressions such as a stray `noindex` or a removed canonical.
- **Launch and migration built in.** `check_urls` follows every redirect chain for up to 20 URLs at once; `test_robots` answers "may this bot fetch this URL" with Google's own matching rules, including `*` and `$` wildcards.
- **Whole sites, step by step.** `start_site_audit` runs as a job the agent works through, so a 25-page audit fits a free hosted service. It reports issues across the site by code, broken and orphan pages and duplicates.
- **You vs the pages that rank.** `compare_pages` puts a page next to up to 3 competitors with content gaps and fixes to catch up; `suggest_internal_links` shows which pages should link where.
- **Knowledge graph ready.** `check_entity_graph` checks that your Organization and authors are real, linked entities with profile links, not just valid markup. `validate_llms_txt` catches the common case where /llms.txt returns an HTML page.
- **Citability, not just crawlability.** AI readiness checks fact density, cited outside sources and whether every question heading gets a direct answer. `compare_pages` shows the facts and figures only a competitor gives, and the ones only you give: information gain, measured against the pages that rank.
- **No made-up advice.** The `onpage://rules` resource gives the assistant every check, threshold and fix, so it explains SEO from the same rules the scanner uses.
- **Free and hosted.** Paste one URL. No account, no API key, no install.

## Install in one minute

[![Add to Cursor](https://img.shields.io/badge/Install%20in-Cursor-0b0b0f?style=for-the-badge)](https://cursor.com/install-mcp?name=onpage&config=eyJ1cmwiOiJodHRwczovL29ucGFnZS5kZXYvbWNwIn0%3D) [![Add to VS Code](https://img.shields.io/badge/Install%20in-VS%20Code-0078d4?style=for-the-badge&logo=visualstudiocode&logoColor=white)](https://vscode.dev/redirect/mcp/install?name=onpage&config=%7B%22type%22%3A%22http%22%2C%22url%22%3A%22https%3A%2F%2Fonpage.dev%2Fmcp%22%7D)

One click for Cursor and VS Code. For Claude, ChatGPT and other clients, see below.

The server is hosted. There is nothing to install or run, and no key.

Fewer tools in context: use `https://onpage.dev/mcp?tools=core` for the 10 main tools (scan, fix pack, scan_html, rescan, render, site audit, prioritise, export).

**Server URL:** `https://onpage.dev/mcp`

<details open>
<summary><b>Claude Code</b></summary>

```bash
claude mcp add --transport http onpage https://onpage.dev/mcp
```

Or install the [plugin](#claude-code-plugin) for the server plus ready commands and skills.
</details>

<details>
<summary><b>Claude (claude.ai and desktop)</b></summary>

Settings → Connectors → **Add custom connector** → paste `https://onpage.dev/mcp` → save. Turn the connector on in a chat.
</details>

<details>
<summary><b>ChatGPT</b></summary>

Add a custom connector with `https://onpage.dev/mcp` (Settings → Connectors, with developer mode on). Which plans can use custom connectors is up to OpenAI.
</details>

<details>
<summary><b>Cursor</b></summary>

`~/.cursor/mcp.json` or `.cursor/mcp.json` in your project:

```json
{
  "mcpServers": {
    "onpage": { "url": "https://onpage.dev/mcp" }
  }
}
```
</details>

<details>
<summary><b>VS Code</b></summary>

`.vscode/mcp.json`:

```json
{
  "servers": {
    "onpage": { "type": "http", "url": "https://onpage.dev/mcp" }
  }
}
```
</details>

<details>
<summary><b>Any other MCP client</b></summary>

Streamable HTTP transport at `https://onpage.dev/mcp`. JSON responses, no authentication.
</details>

## What it can do

71 tools in five jobs. Every result links to the full visual report on [onpage.dev](https://onpage.dev). Issues carry stable codes; the full list is in the `onpage://rules` resource.

### Audit and fix

| Tool | What it does | Example result |
|---|---|---|
| `scan_page` | Score from 0 to 100, the issues to fix first with why and how, AI readiness and key facts | `46/100, 5 fixes` |
| `deep_audit` | Everything measured, by section: speed hints, links and anchor texts, accessibility, image SEO, rich results, security headers, content and technical facts | `8 sections` |
| `get_fix_pack` | Ready-to-paste HTML for every issue, written from the page's own content. With `platform: "git"`: code for Next.js, Nuxt, SvelteKit, Astro, Angular, React or Vue and the steps for a pull request. With `platform: "wordpress"`: the Yoast SEO or Rank Math field per value and the steps to ship it through your WordPress connection. With `platform: "cloudflare"`: a Cloudflare Worker that applies the fixes at the edge, on any CMS | `<title>`, `<meta>`, canonical, social tags |
| `build_edge_rules` | From a finished site audit, one Cloudflare Worker rule per section (for example `/products/*`) that fixes missing or badly sized titles and descriptions, missing canonicals and social tags on every matching page, with a preview. Only fills what is missing or out of range | `/products/*: 212 pages` |
| `get_prerender_worker` | For client-side React, Vue and Angular apps: a Worker that serves AI crawlers the rendered page from Browser Rendering in your own Cloudflare account, cached for a day, while visitors and Google get the normal page. Says so when it is not needed | `12 → 900 words for GPTBot` |
| `generate_schema` | Article, Product, FAQ, Organization or breadcrumb JSON-LD, validated against Google's rich result rules. Values it cannot read are marked TODO, never invented | `Product: eligible` |
| `check_accessibility` | WCAG 2.1 AA report for the European Accessibility Act: every automated check mapped to its success criterion, contrast and reflow from the real-browser check, and what to test by hand | `9 of 11 criteria pass` |
| `check_product_page` | Ecommerce product page: Product and Offer markup, price, stock, identifiers, shipping and return policy for merchant listings, variants, out-of-stock handling and filter URLs | `2 errors, 3 warnings` |
| `check_consent` | Cookie banner and Google Consent Mode v2: which consent platform runs, whether the default comes before the Google tags, ad_user_data and ad_personalization | `Consent Mode v2: missing signals` |
| `check_ga4_tracking` | GA4 debugger in a real browser: installed measurement IDs and GTM containers, then the hits sent on a first visit, after accepting cookies and on a return visit. Finds page_view firing twice, hits before consent, Consent Mode that never updates, debug mode on and Universal Analytics leftovers | `G-XXXX sends 2 page_views` |
| `check_web_vitals` | Core Web Vitals from real Chrome users (CrUX): LCP, INP, CLS, FCP and TTFB on phone and desktop, rated good, needs improvement or poor, with what to fix | `Phone fails: LCP 3.1 s` |
| `rescan_and_compare` | Scan again after a fix: score change, what got fixed, what is new | `46 → 94` |
| `share_result` | A public before and after page to send to a client: score change, fixed and open issues. Not indexed, expires after 90 days | `46 → 94, shareable` |
| `export_findings` | A scan or site audit as an action plan: Google Sheets rows plus a CSV link for `=IMPORTDATA`, a Slack message (or webhook post), one task per issue for Linear, Jira, Asana or GitHub, and a Markdown checklist | `Sheet, Slack, 12 tasks` |
| `measure_impact` | Before and after numbers from Search Console, GA4, Ahrefs or Semrush for the changed pages, against unchanged pages as a control group, with what changed per page from the watch history | `+66% clicks vs control` |
| `diagnose_traffic_drop` | Why traffic dropped: two Search Console periods compared page by page, split into lost rankings, lower search demand, fewer clicks at the same position (AI Overview or snippet) and pages that dropped out, ranked by lost clicks, with the next tool per cause | `3 pages lost rankings` |
| `find_ctr_gaps` | Page-1 results whose click-through rate is far below normal for their position, with the clicks a better title and description could win | `+700 clicks from 4 titles` |
| `find_striking_distance` | Queries at positions 8 to 20 with real impressions, grouped per page, with the clicks a move into the top 5 could win and pages competing for the same query | `23 queries, +1,900 clicks` |
| `check_vitals_trend` | Core Web Vitals from real Chrome users, weekly for about 9 months on phone and desktop, from the Chrome UX Report history. Before and after a fix date, and since when each metric passes | `LCP 4.2 s → 2.2 s` |
| `measure_ai_citations` | AI citations before and after the fixes, per engine (ChatGPT, Perplexity, AI Overviews, AI Mode, Gemini, Copilot), against pages you did not change | `+190% vs control` |
| `log_fix` | Log fixes after they ship (page, field, old and new value, how it shipped). OnPage.dev checks about every 6 hours that each one is still live and posts the restore code to a webhook when a deploy undoes it | `4 fixes logged, all live` |
| `get_fix_log` | The fix log: still live, undone or changed, the restore code, impact per fix from `measure_impact`, a rollback plan for fixes that did worse, and a client-ready monthly report without OnPage.dev branding, plus GA4 annotations for every day fixes shipped | `1 undone, restore ready` |
| `render_page` | The first screen on phone, tablet and desktop in a real browser: H1 and call to action position, cookie walls and pop-ups, tap targets, small text, low-contrast text, what scrolls sideways, mixed buttons, uneven spacing, layout shift, JavaScript-only content, snippet match. With screenshots | `CTA below the fold on phone` |

### Whole site and competitors

| Tool | What it does | Example result |
|---|---|---|
| `start_site_audit` | Audit up to 25 pages from the sitemap as a job. Returns an `audit_id` and the first progress | `3 of 25 scanned` |
| `get_site_audit` | Continue until complete, then read the site-wide results: issues by code with affected pages, broken, orphan and duplicate pages | `25 pages, average 92` |
| `map_link_equity` | Internal PageRank and click depth from a finished audit: pages the home page cannot reach, pages too deep, dead ends, strong pages that pass little on, links through redirects or to broken and noindex pages, and important pages (from Search Console or GA4) with too few links | `3 important pages need links` |
| `create_dashboard_feed` | A daily check of the home page and up to 10 key pages, with the history kept: score, AI readiness, errors and warnings by code, AI crawler access and Core Web Vitals per week | `Feed live, 8 pages daily` |
| `get_dashboard_data` | One dataset from a feed (overview, pages, issues, vitals, fixes, AI access) as a table with a date column and full URLs, ready to join with GA4, Search Console or their BigQuery exports | `30 days, 8 pages` |
| `build_seo_dashboard` | A designed dashboard for Claude Dashboards or an artifact: realtime GA4 (users per minute, pages, events, countries), traffic, SEO health, fixes, speed and AI visibility, in light and dark | `Dashboard with 9 panels` |
| `suggest_internal_links` | Which audited pages should link to a page, with anchor text. Works for a new page by topic | `3 links to add` |
| `map_topics` | Topic clusters from Search Console rows: which page owns each topic, where pages compete, topics without their own page, pages without search demand and the internal links to add | `14 topics, 3 compete, 2 gaps` |
| `prioritize_fixes` | Rank fixes by traffic impact, using numbers from your connected Search Console, GA4, Ahrefs or Semrush: blockers, low CTR, striking distance, missing keywords, strong links on a weak page. Falls back to severity | `#6 → top 3, ~336 clicks/mo` |
| `match_intent` | Does the page match search intent? Scans the top results you pass (from Ahrefs or Semrush), works out the page type Google ranks (guide, listicle, product, category, service, forum, video and more) and the format that ranks. With Search Console rows: pages that compete for the same query | `Mismatch: results are listicles, yours is a product page` |
| `check_readability` | Reading ease with the formula for the page language (Flesch, Flesch-Douma, Amstad, Kandel-Moles, Fernández-Huerta, Flesch-Vacca) against the pages that rank or the norm for the page type, average sentence length, long sentences, and the hardest sentences and paragraphs to rewrite | `63 vs 52 for ranking pages` |
| `check_og_tags` | Open Graph and Twitter tags plus the real share image (loads? size in pixels, type, weight) against what Facebook, LinkedIn and X need. Also a free REST API: `GET /api/v1/og?url=` | `og:image returns 404` |
| `compare_pages` | A page next to up to 3 competitors: side by side, content gaps, structured data they have and fixes to catch up. Flags cookie walls | `You lead on 12 of 14` |

### AI search

| Tool | What it does | Example result |
|---|---|---|
| `check_ai_visibility` | Which AI crawlers may read the page (GPTBot, ClaudeBot, PerplexityBot, Google-Extended and more), llms.txt, 15 checks for AI answers, and the page as a model reads it | `7 of 8 crawlers allowed` |
| `submit_indexnow` | Tell Bing, Yandex and other IndexNow engines that pages changed, right after a fix goes live. Sets up the key file the first time | `12 URLs accepted` |
| `analyze_logs` | What Googlebot, Bingbot and 14 AI crawlers really request, from your access logs: hits per bot, errors and redirects they get, crawl budget on parameters, and sitemap pages Googlebot never visits | `GPTBot: 212 hits, 9% errors` |
| `find_duplicate_content` | Near-duplicate pages from a site audit, grouped by the text outside menus, header and footer, with the page to keep and what to do with the rest (canonical, merge, rewrite, or variants as options for product pages) | `2 groups, 8 pages` |
| `check_url_parameters` | Every query parameter in the audit's links classified as tracking, session, search, sort, pagination or filter, with crawl traps, pagination canonicals and the robots.txt rules to fix them | `utm in 14 internal links` |
| `explain_index_status` | Search Console URL Inspection results (or Pages report rows) grouped by cause, most serious first: noindex, robots.txt, a canonical Google ignores, crawled or discovered but not indexed, soft 404, server and redirect errors, with the fix and the next tool | `12 crawled, not indexed` |
| `check_hreflang` | Multilingual sites: valid language and region codes, x-default, then every language version: status, noindex, canonical, return tags and html lang. Returns the corrected tag set | `4 versions, 1 missing return tag` |
| `check_trust_signals` | E-E-A-T across the site: About, Contact, Privacy and Terms pages (found in English, Dutch, German, French and Spanish), email, phone, address, company and VAT numbers, Organization markup, social profiles, author and dates | `6 of 8 checks pass` |
| `check_local_seo` | Local businesses: LocalBusiness markup (specific type, address, phone, opening hours, geo), whether name, address and phone match the pages, the Google Business Profile link, a map, the city in the title, and a page with its own markup per location. Writes corrected JSON-LD with TODOs | `NAP mismatch: phone` |
| `check_question_coverage` | Coverage for AI Mode and AI Overviews: your assistant writes the sub-questions an AI search engine fans out for a topic, the tool rates each one answered, buried, partial or missing on your page (and up to 2 competitors) and lists the sections to add | `60/100, 2 missing` |
| `check_answer_format` | Featured snippets and People Also Ask: the answer format that wins on the pages that rank (paragraph and length, list and items, or table) against your section, with the rewrite | `Winning: list of 7, yours: paragraph` |
| `find_answer_passages` | Does the page answer a question well enough for AI to quote it? Returns the best passages with length and fit | `Best passage, 64 words` |
| `ai_crawler_policy` | robots.txt rules for 13 AI crawlers from a policy (allow all, AI search only, block all), merged into your existing file | `13 bots, merged` |
| `generate_llms_txt` | A ready `llms.txt` built from the sitemap and home page | `llms.txt, 42 pages` |
| `validate_llms_txt` | Check an llms.txt against the llmstxt.org format: a real text file (not an HTML soft 404), one title, a summary, sections with `[name](url): notes` links, size, dead links, and whether llms-full.txt exists. Validates drafts too | `Valid, 6 sections, 8 of 8 links load` |
| `check_entity_graph` | How the structured data describes who is behind a page, the way AI knowledge graphs read it: Organization, author and publisher as linked entities (`@id`), `sameAs` profiles that load, a match with the home page, and the missing JSON-LD with TODOs | `5 entities, 1 fix: no sameAs` |
| `screen_reader_view` | How screen readers and browsing AI agents read the page: landmarks, heading outline, every link, button, image and field with its name, and what is missing | `3 links without a name` |
| `compare_ai_citations` | AI citation counts per page from Ahrefs Brand Radar or another source, next to OnPage.dev checks: which checks the cited pages pass and the others fail, averages side by side, and what each skipped page should change | `Clear answer first: 100% of cited pages vs 0%` |
| `watch_page` / `get_watch` / `unwatch` | A daily check for regressions: page down or redirected, noindex added, AI crawlers blocked, canonical or title changed, score drop, new and fixed issues. Private RSS feed, optional Slack or Discord webhook. With `competitor_of`: follows a competitor's page, and each new section, structured data type or length jump comes with the counter-move for your page | `noindex added, alert sent` |

### Launch and migration

| Tool | What it does | Example result |
|---|---|---|
| `check_urls` | Status codes and full redirect chains for up to 20 URLs, checked against where each should land. Flags chains and temporary redirects | `19 of 20 OK` |
| `check_sitemap` | The XML sitemap: found through robots.txt, index followed, format and limits, foreign hosts, fake or future lastmod dates, plus a sample of listed URLs checked for redirects, errors, noindex and canonicals elsewhere, with corrected entries | `4 of 12 URLs do not belong` |
| `extract_from_pages` | One value from up to 20 pages, by CSS selector (with an attribute), regular expression or JSON-LD path such as `Product.offers.price`, to verify a template fix at scale | `18 of 20 have a price` |
| `plan_redirects` | Old URLs to new ones with a confidence score per match, written as `_redirects`, nginx, Apache, Next.js or CSV rules | `212 matched, 9 to review` |
| `fix_broken_backlinks` | Broken backlinks from Ahrefs or Semrush ranked by link value, checked live, matched to the best live page and written as 301 rules | `14 pages, 38 sites back` |
| `test_robots` | May Googlebot, GPTBot, ClaudeBot or any crawler fetch this URL? Uses Google's matching rules and returns the exact deciding rule. Can test a proposed robots.txt too | `Blocked by "Disallow: /search?"` |

### Writing and code

| Tool | What it does | Example result |
|---|---|---|
| `scan_html` | Scan HTML that is not live yet: a local build, a template or a draft. Same score and fixes as `scan_page` | `92/100 before deploy` |
| `compare_html` | SEO diff between two versions of a page: score, issues fixed and introduced (by code), and changes to title, description, H1, canonical, robots and structured data | `72 → 18, noindex added` |
| `validate_schema` | Check JSON-LD you wrote: syntax, @context and @type, ISO dates, absolute URLs, placeholders and Google's required fields | `2 errors, 3 warnings` |
| `check_focus_keyword` | Eight checks for one search term: title, description, H1, URL, opening text, subheadings, alt texts and keyword use | `6 of 8` |
| `check_snippet` | Pixel-width estimate of title and description against Google's cut-off, desktop and mobile | `612 px, cut off` |
| `create_content_brief` | A writing brief from the pages that rank: subtopics, questions, figures, target length, schema, title patterns and internal links | `8 topics, 5 questions` |
| `get_layout_probe` / `analyze_layout` | Run the first-screen checks in your own browser tool: no daily limit, works on staging and localhost | `First screen, 3 devices` |

### Ready workflows (MCP prompts)

One click in clients that show prompts:

- **Full SEO and AI audit**: scan, AI check and fix pack, then a prioritised plan.
- **Why can't AI find my site?**: which assistants can read and quote you, and what to change.
- **Launch checklist**: a tick or cross for everything a page needs before going live.
- **AI visibility makeover**: robots.txt, llms.txt and answer passages in one go.
- **Pre-deploy SEO gate**: scan the built HTML and block the release below a minimum score.

### Reference resource

`onpage://rules`: every check with its stable code, why it matters and how to fix it, plus the key thresholds (title and description length in pixels, word counts, alt text, server response, AI answer length).

### Score card in the chat

In clients that support MCP Apps (Claude) or the Apps SDK (ChatGPT), scan results also show as a visual card:

<p align="center"><img src="assets/score-card.png" alt="OnPage.dev score card in the chat: score 46, AI readiness 27, and the fixes to make first" width="420"></p>

## Why it is different

|  | OnPage.dev | Data vendor MCPs (Ahrefs, Semrush and similar) | Self-hosted audit servers |
|---|---|---|---|
| Price | Free | Paid plan or API credits | Free |
| Setup | Paste one URL | Account and key | Install and run yourself, often extra API keys |
| Built for | Acting on results: fix, check before deploy, confirm | Research data: keywords, backlinks, rankings | Audits and reports |
| Scan unpublished HTML | Yes, `scan_html` and `compare_html` | No | Rarely |
| Agent-grade output | Stable issue codes, output schemas, rules resource | Data rows | Varies |
| Migration checks | Redirect chains, robots.txt tester | Partly | Partly |
| Whole-site audit | Up to 25 pages, free, as a job | Yes, paid | Yes, self-run |
| Competitor gaps | Page vs page, with content gaps | Keyword and backlink gaps | Rarely |
| AI search tools | Crawler access, AI-answer checks, robots.txt policy, llms.txt | AI visibility tracking on some | Rarely |
| Ready code | Fix pack, JSON-LD, robots.txt, llms.txt | No | Varies |
| Uses your traffic data | Yes, from GSC, GA4, Ahrefs or Semrush already in the chat | Their own data | Rarely |
| Explains AI citations | Cited vs skipped pages, checked side by side | Citation counts only | No |
| Monitoring and alerts | Daily watch, RSS and webhook, free | Yes, paid | Rarely |
| Real-browser first screen | Phone, tablet, desktop, with and without JavaScript | No | Rarely |
| Client-side apps (React, Angular, Vue) | Full audit of the rendered page, plus what AI crawlers miss | No | Rarely |
| Accessibility report | WCAG 2.1 AA, mapped per criterion, for the European Accessibility Act | No | Rarely |
| Ships fixes | WordPress, or a Git pull request with framework code | No | Rarely |
| Server log analysis | Googlebot and 14 AI crawlers, sitemap gaps | No | Some |
| Real-user Web Vitals | Chrome UX Report, phone and desktop | Some | Some |
| Screen reader view | Accessibility tree read aloud, unnamed controls flagged | No | Rarely |
| Measures the result | Before and after, with a control group | Rank and traffic charts | Rarely |
| From findings to tasks | Google Sheets, Slack, Notion and task boards, no connector needed for Sheets | Exports to CSV or PDF | Rarely |
| Migration redirect map | Old to new with confidence, ready rules | No | Rarely |

Full comparison with the Ahrefs, Semrush, SE Ranking and DataForSEO MCP servers, with prices: [onpage.dev/compare](https://onpage.dev/compare).

What OnPage.dev does not have: its own search volumes, rankings or backlinks. Connect a data vendor in the same chat and OnPage.dev turns their numbers into ranked fixes.

## Example prompts

```
Why does ChatGPT never mention example.com? Check it with OnPage.dev.
Scan our pricing page and give me the five fixes with the code.
Let ChatGPT search read our site but block AI training. Write the robots.txt.
We moved to a new URL structure. Check that these 20 old URLs redirect to the right new pages.
Review this pull request for SEO regressions: compare the old and new HTML of the changed pages.
Audit our whole site and tell me the three fixes that help the most pages at once.
We are writing a page about trail running shoes. Which of our pages should link to it?
How does our pricing page compare with these two competitors, and what are we missing?
Does our blog post answer "how long does shipping to Germany take" well enough for AI to quote?
Write three title options for this page and check which ones fit in Google.
Fix the SEO issues in this project, check the build with OnPage.dev and keep going until it scores 95.
```

## Claude Code plugin

The server plus commands and skills that run the fix loop for you.

```
/plugin marketplace add seoonpage/seo-mcp-server
/plugin install onpage@onpage-dev
```

- `/seo-check [url or path]`: scan a live page, or find this project's built HTML and scan that, then fix what is wrong.
- `/ai-visibility`: check whether ChatGPT, Claude, Perplexity and Gemini can read and quote the site, and write `robots.txt` and `llms.txt`.
- **seo-fix-loop** skill: fixes in your source (templates, Next.js `metadata`, Astro frontmatter), checks with `scan_html` before deploy and confirms with `rescan_and_compare` after.

About 300 tokens of always-on context.

## GitHub Action: SEO gate

Scans the HTML your build produces on every pull request, comments the scores and top fixes, and fails when a page drops below your minimum.

```yaml
name: SEO gate
on: pull_request
permissions:
  contents: read
  pull-requests: write
jobs:
  seo:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v5
      - run: npm ci && npm run build
      - uses: seoonpage/seo-mcp-server@v1
        with:
          paths: "dist/**/*.html"          # built HTML to check
          base-url: "https://example.com"   # optional, for canonical and relative links
          min-score: "80"                   # fail below this
          max-files: "10"                   # about 20 scans per minute
```

The pull request gets a comment like this, updated on every push:

> ### ❌ OnPage.dev SEO gate: lowest score 36 (minimum 80)
> | Page | Score | AI readiness | Fix first |
> |---|---:|---:|---|
> | `dist/about/index.html` | **36** | 0 | There is no meta description; There is no H1; The title is 5 characters |
> | `dist/index.html` | 90 | 22 | Thin content: 32 words; No structured data; Open Graph is incomplete |

## GitHub Action: fix guard

Keeps shipped fixes live. Once a day it asks OnPage.dev whether every fix in your fix log is still on the page. When a deploy undid one, it opens an issue with the restore code; when all are live again, it closes the issue. It uses the repository's own token, so OnPage.dev never gets access to GitHub.

```yaml
name: SEO fix guard
on:
  schedule:
    - cron: "0 7 * * *"
permissions:
  issues: write
jobs:
  guard:
    runs-on: ubuntu-latest
    steps:
      - uses: seoonpage/seo-mcp-server/guard@v1
        with:
          fix-log-id: "YOUR_FIX_LOG_ID"   # from log_fix
          fail-on-regression: "false"     # true to fail the run as well
```

Your coding agent can pick the issue up and open the pull request with the value restored.

## Security and privacy

- **Nothing changes on your site by itself.** OnPage.dev only reads public pages or the HTML you send. Fixes ship through your own tools (your git, your WordPress, your Cloudflare), after you approve them. Watches and shared result pages store scores and issue names, never page content; fix logs store the URLs and the old and new values you log.
- **Public pages only.** Private, internal and local network addresses are refused (SSRF protection), and so are non-web schemes.
- **No storage of content.** HTML sent to `scan_html` is analysed in memory and dropped. For change tracking, only the score and issue names are kept, under a hashed key, for up to 30 days.
- **Your traffic data stays yours.** Numbers passed to `prioritize_fixes` or `measure_impact` are used for that answer only, except that `measure_impact` with a `fix_log_id` saves the before, after and change per logged page in that fix log. OnPage.dev never connects to Search Console, GA4, Ahrefs or Semrush itself.
- **Prompt injection aware.** Text from scanned pages is returned as data and marked as such.
- **Fair use limits.** About 20 scans per minute per connection, plus a shared cap. Real-browser checks (`render_page`, `screen_reader_view`) share a daily budget; with your own browser tool, `get_layout_probe` has no limit. No accounts, no keys, no tracking cookies.

Full details: [onpage.dev/privacy](https://onpage.dev/privacy) and [onpage.dev/terms](https://onpage.dev/terms).

## Good to know

- The main scan reads the HTML a server returns, the way AI crawlers do. When that HTML is an empty shell from a client-side React, Angular or Vue app, `scan_page` loads the page in a real browser and audits the rendered page instead, and reports how many words crawlers without JavaScript get. This shares the daily real-browser budget; when it runs out you get the raw-HTML scan with a warning. `render_page` and `screen_reader_view` add phone, tablet and desktop views, with and without JavaScript.
- Link checks, image sizes and AI crawler access need a live URL, so `scan_html` skips them.
- Pixel widths in `check_snippet` are an estimate; Google can also rewrite snippets.

## Links

- Web app: [onpage.dev](https://onpage.dev)
- MCP server and setup: [onpage.dev/mcp](https://onpage.dev/mcp)
- Questions: [hi@onpage.dev](mailto:hi@onpage.dev) or [open an issue](https://github.com/seoonpage/seo-mcp-server/issues)

## License

MIT
