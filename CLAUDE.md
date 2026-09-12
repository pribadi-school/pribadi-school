# Sekolah Pribadi Depok — project notes

WordPress site for SD-SMP-SMA Pribadi Depok, running locally under **LocalWP**.
Local domain: `http://sekolahpribadi.local/`. Deployed (staging/preview) at
`new.pribadidepok.sch.id`; production domain is `pribadidepok.sch.id`.

## The homepage is deliberately NOT Elementor

The homepage (post ID **3252**) renders from a hand-written theme template,
`wp-content/themes/oceanwp-child/page-homepage-custom.php`, selected via the
`_wp_page_template` postmeta.

**Do not move it back to Elementor.** The reason is not preference: Elementor's
editor overwrites the entire `_elementor_data` document on every "Update", with
no merge against out-of-band changes. Direct database edits to that page were
silently destroyed three separate times (the achievements ticker, a card image
crop, and the whole "Prestasi Siswa" section, which had to be recovered from a
WP revision). Assigning a real page template takes Elementor out of the
rendering path entirely, because the template never calls `the_content()`.

Elementor's `_elementor_data` for post 3252 is still in the database, dormant.
Reverting is just setting `_wp_page_template` back to default — nothing was
deleted.

The site **header and footer still come from Elementor Theme Builder**
(header = post 1991, footer = post 69) and are shared with every other page.
Those are untouched by the homepage template.

### If you ever do edit Elementor content directly in the DB

Clear its caches afterwards or you will be served stale HTML and conclude your
edit didn't work:

```sql
DELETE FROM wpzn_postmeta WHERE meta_key IN ('_elementor_element_cache', '_elementor_css');
```

## Child theme layout

Everything custom lives in `wp-content/themes/oceanwp-child/`:

```
page-homepage-custom.php          homepage template ("Homepage (Custom)")
template-parts/achievements-showcase.php
assets/css/homepage.css           homepage styles, only enqueued for that template
assets/css/transparent-header.css front-page-only floating header behaviour
assets/js/                        scroll-reveal, transparent-header, hero-text-scroll,
                                  achievements-counter, achievements-tile-tap, nav-dropdown-tuning
style.css                         site-wide overrides (applies to ALL pages)
functions.php                     conditional enqueues
```

Two rules worth knowing:

- **`style.css` is site-wide; `assets/css/*.css` are conditional.** Header *size*
  (top bar hidden, section padding, logo height) lives in `style.css` on purpose,
  so every page gets one consistent header. `transparent-header.css` only adds the
  front-page floating/colour behaviour on top of that. Putting size rules back in
  the conditional file makes interior pages render a taller header.
- The homepage hero is `position: sticky`. That means `#homepage-custom` must use
  `overflow-x: clip`, **not** `hidden` — `hidden` turns an ancestor into a scroll
  container and silently breaks sticky. It also means the transparent-header
  script can't watch the hero to decide when to go solid (a pinned hero never
  scrolls away), so it watches the 1px `.hp-hero-sentinel` after it instead.

## Design system

`design-system/sekolah-pribadi-depok/MASTER.md` is the source of truth for
colour, type, spacing, elevation and motion tokens. It was generated with the
`ui-ux-pro-max` skill and then **hand-corrected** — the tool's auto-match pulled
a "kids' learning app" profile that doesn't fit a K-12 school. Read it before
regenerating, and don't overwrite it wholesale.

Its hard rule: every colour in component CSS must trace back to a token in that
file. No ad-hoc hex values.

## Local environment gotchas

- **PHP CLI:** the system `php` on PATH lacks `mysqli`. Use LocalWP's bundled
  binary for anything that bootstraps WordPress:
  `C:\Users\<user>\AppData\Roaming\Local\lightning-services\php-8.2.29+0\bin\win64\php.exe`
- **MySQL client:** use the MySQL 8.4 client, not MariaDB's — MariaDB's client
  can't do `caching_sha2_password` against this server.
- Table prefix is `wpzn_`, not `wp_`.

## Git / GitHub

This repo is connected to GitHub: `origin` → https://github.com/pribadi-school/pribadi-school
(branch `main`, tracking `origin/main`). git works fine on PATH — commit and push
normally.

## Deployment

Pushing to `main` is not enough by itself — deployment happens via **cPanel Git
Version Control** ("Pull or Deploy") on the `new.pribadidepok.sch.id` cPanel
account (user `pribadisch`), configured in [.cpanel.yml](.cpanel.yml). On deploy,
cPanel copies only `wp-content/themes/oceanwp-child/` into that site's live theme
directory — WP core, plugins, and the database are managed separately by the
host, not by this repo. After pushing, trigger (or wait for) the cPanel pull to
actually update `new.pribadidepok.sch.id`.

## What is NOT in this folder

The **database is not part of these files.** The homepage template assignment,
all page content, and menus live in MySQL. Copying `app/public/` alone will not
carry the site — use LocalWP's own **Export** (right-click the site in Local) to
get files *and* database together.

`.gitignore` deliberately excludes `*.sql` and `wp-content/uploads/`: database
dumps contain real student/parent data and shouldn't go into a git remote.
