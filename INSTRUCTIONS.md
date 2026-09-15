# Coming Soon Page — Setup Instructions

Built to slot into your existing repo (`the-warrington-group-site-v1`) and workflow
described in `twg-kirby-cms-workflow.md`.

## What's included

```
site/templates/coming-soon.php     → the landing page itself
site/templates/leads.php           → guard template (redirects if visited directly)
site/templates/lead.php            → guard template (redirects if visited directly)
site/blueprints/pages/leads.yml    → Panel table view of all submissions
site/blueprints/pages/lead.yml     → Panel view of a single submission
content/leads/leads.txt            → parent page that stores submissions as children
site/config/config.php             → your existing config + the new /stay-in-contact route
```

## 1. Add your logo

Drop your black-background logo into:

```
assets/images/twg-logo-black-bg.png
```

(PNG or SVG both work — if you use a different filename or `.svg`, update the
`src` in `site/templates/coming-soon.php` to match.) Since a transparent or
black background works best against the gold gradient, a PNG with transparency
or your existing black-background version is ideal — no need to re-export it.

## 2. Set (or confirm) the launch date

Near the top of `site/templates/coming-soon.php`:

```php
$launchDate = '2026-10-01T00:00:00-04:00'; // Oct 1, 2026, America/New_York
```

Adjust the year/timezone if needed — the countdown reads directly from this value.

## 3. Merge the config changes

I rebuilt `site/config/config.php` on top of the settings already documented in
§5 of your workflow doc, adding a `routes` entry for `/stay-in-contact` that
handles the form POST. If you've made other changes to config.php since that
doc was written, merge the `routes` array into your current file rather than
overwriting it wholesale.

## 4. Swap the homepage template (no Panel changes needed)

Because Kirby derives a page's template from its `.txt` filename (not the
folder name), you can swap templates with a simple rename — no blueprint or
Panel work required:

```bash
# back up the real homepage content first
cp content/home/home.txt content/home/home.txt.bak

# swap it to the coming-soon template
mv content/home/home.txt content/home/coming-soon.txt
```

**When the real site is ready to launch:**

```bash
mv content/home/coming-soon.txt content/home/home.txt
```

This reverses cleanly — nothing about your actual homepage content is touched,
only which template renders it.

## 5. Test locally

Per your existing workflow:

```bash
composer install   # if you haven't already
php -S localhost:8000
```

Visit `http://localhost:8000` and confirm:
- the countdown is ticking down to your launch date
- "Stay in Contact" opens the modal and the form submits successfully
- a new entry appears under **Leads** in the Panel (`/panel`) after submitting

## 6. Deploy

Same as always — commit and push to `main`:

```bash
git add .
git commit -m "Add coming-soon landing page with countdown and lead capture"
git push origin main
```

Auto-deploy via Cloudways' **Deployment via Git** will pick it up. If the page
doesn't reflect changes right away, it's most likely Cloudflare cache — purge
it (Cloudflare → Caching → Purge Everything) as noted in your workflow doc.

## 7. Important: back up your leads periodically

One thing worth flagging given how this repo is set up: `content/` is tracked
in git, but **new lead submissions are created live on the server**, not in
your local repo. Your normal `git pull`-based deploys shouldn't delete them
(Cloudways' Git deployment won't remove untracked files it doesn't manage),
but they also **aren't backed up anywhere else** — they only exist on the
Cloudways server's filesystem.

Recommended: every so often (or right before you flip the coming-soon page
back to the real homepage), pull `content/leads/` down from the server and
either commit it to git or export it elsewhere, so you don't lose prospective
client contacts if anything happens to the server.

## Viewing submissions

Log into `/panel`, and you'll see a **Leads** entry in the page tree with a
table of every submission (name, business, email, phone, submitted date).
Click into any row to see the full "Additional Details" text.
