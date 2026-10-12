# Security policy

## Reporting a vulnerability

Please do not open a public issue for security problems.

Report privately in one of two ways:

- **GitHub:** use [Report a vulnerability](https://github.com/seoonpage/seo-mcp-server/security/advisories/new) on this repository.
- **Email:** hi@onpage.dev

Include the URL or tool name, the steps to reproduce, and what an attacker could do with it. We confirm when we have it, keep you posted while we fix it, and credit you in the advisory if you want.

## Scope

- The hosted MCP server at `https://onpage.dev/mcp` and its 88 tools
- The website and public endpoints on `onpage.dev`
- The GitHub Action, Claude Code plugin and skills in this repository

Examples we want to hear about: server-side request forgery through scanned URLs, ways around the rate limits or per-visitor caps, data from one user reaching another (watches, exports, share links), and prompt injection that makes a tool act outside its description.

## Out of scope

- Findings on sites you scanned with OnPage.dev. Report those to the site owner.
- Volumetric denial of service and load testing. Please do not run them against onpage.dev.
- Missing security headers without a working attack.
- Issues in your own AI client or in third-party connectors.

## How we handle data

OnPage.dev needs no account and sets no cookies. HTML and traffic numbers sent to the tools are used for that one answer and not stored. See the [privacy page](https://onpage.dev/privacy) for exactly what is kept and for how long.

## Supported versions

Only the hosted service and the latest release in this repository get security fixes.
