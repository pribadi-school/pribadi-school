# Sekolah Pribadi Depok — project notes

WordPress site for SD-SMP-SMA Pribadi Depok, running locally under **LocalWP**.
Local domain: `http://sekolahpribadi.local/`. Production is `pribadidepok.sch.id`.

The redesign (this theme) was built and previewed on a separate staging
subdomain, `new.pribadidepok.sch.id`, then promoted to production on
2026-09-14 by copying the `oceanwp-child` theme folder over and switching the
homepage's page template. `new.pribadidepok.sch.id` still exists as a
leftover staging copy but no longer auto-deploys (see Deployment below) and
isn't kept in sync with production going forward.

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
(header = post 1991, footer = post 69 — those IDs are for the local dev site;
production has its own separate Elementor header/footer posts, since Theme
Builder content lives in the database, per-install, and doesn't travel with
this repo) and are shared with every other page. Those are untouched by the
homepage template.

OceanWP's own built-in page header (the "Home"-style title bar above page
content) is a *different* thing from Elementor's header, controlled by a
sitewide Customizer setting rather than anything in this repo. Since that
setting doesn't travel between WordPress installs either, `functions.php`
explicitly hides it for `page-homepage-custom.php` via the
`ocean_display_page_header` filter, so it stays hidden regardless of
Customizer state on whatever site this theme runs on.

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
template-parts/magazine.php       Pribadi Magazine section, shared by homepage + story pages
template-parts/story-page.php     shared "story page" layout (intro, filtered one-at-a-time
                                  story carousel with arrows, magazine)
page-prestasi.php                 "Prestasi (Custom)" story page, data in
                                  template-parts/data/achievement-stories.php
page-digital-classroom.php        "Digital Classroom (Custom)" story page, data in
                                  template-parts/data/digital-classroom.php
assets/models/                    3D models (.glb) shown with Google's <model-viewer> on story
                                  pages - a story with 'model' in its data file gets one
                                  (see oceanwp_child_enqueue_model_viewer() in functions.php)
assets/css/homepage.css           homepage styles, only enqueued for that template
assets/css/prestasi.css           story-page styles (both story pages; see
                                  oceanwp_child_story_page_templates())
assets/css/magazine.css           shared magazine section, enqueued for all of the above
assets/css/photo-strip.css        the scrolling photo strip (loops, drag, hover caption) shared by
                                  the homepage achievements and the school pages' hero
                                  (page-school.php 'strip' in template-parts/data/schools.php);
                                  driven by assets/js/achievements-marquee.js + -tile-tap.js
assets/css/transparent-header.css front-page-only floating header behaviour
assets/js/                        scroll-reveal, transparent-header, hero-text-scroll,
                                  achievements-counter, achievements-tile-tap, nav-dropdown-tuning
assets/css/preloader.css          intro loading screen (tuning knobs at the top)
assets/js/preloader.js            ...its show/exit logic
style.css                         site-wide overrides (applies to ALL pages)
functions.php                     conditional enqueues
```

The **intro preloader** is printed *inline* in `<head>` by `functions.php`
(not enqueued) so it styles the very first paint and LiteSpeed can't defer it.
Two consequences: its CSS/JS source must never contain a literal head, body
or html tag, even in a comment - HTML optimisers regex-inject after the first
match and would split the script (this happened in testing). And it only shows
on the first page of a tab session; add `?preloader` to any URL to force it.

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

Pushing to `main` is not enough by itself — the live site only updates once
the server-side git clone is pulled and its `.cpanel.yml` deploy task is run
to copy `wp-content/themes/oceanwp-child/` into production's live theme
directory. WP core, plugins, and the database are managed separately by the
host, not by this repo.

**The cPanel → Git™ Version Control UI page has shown up empty** (no
repositories listed) even though a real, working clone exists on disk and
deploys fine from Terminal — don't trust that page as a sign nothing is
connected. Deploy via Terminal instead, since it's what's actually been
reliable (verified 2026-09-14):

```bash
cd ~/repositories/oceanwp-child
git fetch origin
git reset --hard origin/main
export DEPLOYPATH=/home/pribadisch/public_html/wp-content/themes/oceanwp-child/
cp -R wp-content/themes/oceanwp-child/. $DEPLOYPATH
```

The real repo clone is `~/repositories/oceanwp-child` — remote
`github.com:pribadi-school/pribadi-school.git`, `.cpanel.yml` inside it
controls `DEPLOYPATH`. (Earlier notes guessed the clone lived under
`public_html/new.pribadidepok.sch.id/wp-content/themes/oceanwp-child-git/` —
that path turned out to be wrong; ignore it if it comes up again.)

There's a second folder, `~/repositories/pribadi-school-oceanwpchild`
(confirmed 2026-09-14: completely empty, not a git repo, no `.cpanel.yml`) —
an abandoned leftover from an earlier setup attempt. It isn't connected to
anything and is safe to ignore.

After a deploy, verify it actually landed before assuming it did — e.g.
`grep -c "mdash" ~/public_html/wp-content/themes/oceanwp-child/page-homepage-custom.php`
should read `0` once the em-dash-removal commit is live. If a PHP change
doesn't seem to have taken effect but the deploy clearly ran, flush OPcache
(`php -r "opcache_reset();"` if available) and purge LiteSpeed Cache — see
the OPcache/caching gotcha above; it applies to every deploy, not just that
first one.

(There's reportedly a `~/deploy-pribadi.sh` script on the server that may
wrap the fetch/reset/copy steps above — unconfirmed what it actually does,
check its contents before relying on it.)

## What is NOT in this folder

The **database is not part of these files.** The homepage template assignment,
all page content, and menus live in MySQL. Copying `app/public/` alone will not
carry the site — use LocalWP's own **Export** (right-click the site in Local) to
get files *and* database together.

### OceanWP's Customizer settings don't travel with the theme

Learned the hard way promoting the redesign to production on 2026-09-14.
Copying the `oceanwp-child` folder to a new install gets you the *code* but
none of OceanWP's settings: page title bar on/off, top bar, header style,
logo height, colours. Those are **theme mods**, stored in `wp_options` under
`theme_mods_oceanwp-child` — per theme slug, per install. A freshly activated
child theme starts with an empty set, so every OceanWP default switches back
on, most visibly the grey page title bar on *every* page.

Migrate them with the **Customizer Export/Import** plugin (export on the
source site, import on the target, ticking "download and import image files"
so logo/image settings don't stay pointed at the source site's attachment
IDs). Don't try to fix the symptoms one at a time with CSS or PHP filters —
`functions.php` does hide the page header for `page-homepage-custom.php` via
`ocean_display_page_header`, but that is a guarantee for that one template,
not a substitute for the settings.

### PHP changes can lag behind file changes on the live host

Production is LiteSpeed on Hostinger with OPcache. After a deploy, CSS,
images and video update immediately while `functions.php` keeps running the
old bytecode — so a PHP fix looks like it "didn't deploy" when the static
assets from the same commit are plainly live. That asymmetry is the tell.
Flush OPcache (hPanel's PHP/cache tool, or toggle the PHP version) before
concluding a PHP change didn't land. LiteSpeed's page cache is worth purging
at the same time.

`.gitignore` deliberately excludes `*.sql` and `wp-content/uploads/`: database
dumps contain real student/parent data and shouldn't go into a git remote.
