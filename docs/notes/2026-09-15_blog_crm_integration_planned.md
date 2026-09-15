# Blog → CRM integration (planned, not started)

**Status:** deferred. Owner decision on 15.09.2026.
**Precondition:** the CRM must be moved to the new server first. Nothing starts before that.

## What was asked for

The blog on `body-health.care` should stop being a set of hand-edited static
files and become a publishing pipeline driven from the CRM:

- **Doctors write.** A doctor working in the CRM can draft a publication there,
  in the same system where they already work with residents — not in a separate
  CMS and not by sending text to a developer.
- **An administrator approves.** A draft is not public when it is written. An
  administrator reviews it and decides whether it is published.
- **The administrator controls the release order.** Approved posts are not all
  dumped at once; the administrator releases them one after another, on a
  schedule they set. The word the owner used was that the administrator
  "выдаёт" them — hands them out sequentially.

## Why this is not started yet

The CRM is being moved to another server. Building a publishing path out of the
current CRM would mean building it twice. The owner's instruction was explicit:
site fixes and cleanup now, this integration as the next stage after the
migration.

## What the current site looks like going in

As of 15.09.2026 the blog is seven static HTML files under `resources/views/blog/`
plus an index at `resources/views/blog.html`, all Ukrainian, built by `build.sh`
into `dist/` and deployed by GitHub Actions on push to master.

The index cards are now generated from each article's own `h1`, date, read time
and excerpt rather than being maintained separately — they had drifted badly
(December 2024 dates on 2026 articles, three titles that no longer matched).
Whatever replaces this should keep that property: one source of truth per
article, with the listing derived from it.

Article pages share one canonical header and footer with the rest of the site,
with absolute internal links, so a generated article page only needs to supply
the body between them.

## Open questions for when this starts

- Where the article body is authored and stored — CRM database, or files the
  CRM writes and commits.
- How a published article reaches Cloudflare Pages: a build triggered by the
  CRM, or the site reading from an API at request time.
- Whether the three site locales (uk/en/ru) apply to articles, and who
  translates them. Today articles exist in Ukrainian only.
- Whether doctors' bylines come from their CRM profile.
