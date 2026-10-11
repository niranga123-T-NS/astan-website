# ASTAN International (Pvt) Ltd & ANTS Design Ventures — Website

Group website for **ASTAN International (Pvt) Ltd** (Reg. PV 00348027) and its design arm **ANTS Design Ventures** (Reg. WC 20949), Thalawathugoda, Sri Lanka.

Built with plain PHP, HTML, CSS and JavaScript: no database and no WordPress. It runs on any GoDaddy **cPanel (Linux) hosting** plan with PHP 8.0 or newer.

## What's included

| Address | Page |
|---|---|
| `/` | ASTAN home page |
| `/about.php` | About the group (ASTAN + ANTS) |
| `/services.php` | All 8 ASTAN services in 4 divisions |
| `/portfolio.php` | Combined portfolio with ASTAN / ANTS and category filters |
| `/project.php?p=…` | Individual project page with photo gallery |
| `/contact.php` | Contact details, enquiry form (to info@astan-int.lk), map |
| `/ants/` | ANTS Design Ventures studio page with its own enquiry form (to info@antsdv.lk) |
| `/ants/portfolio.php` | ANTS-only portfolio |
| `/admin/` | **Password-protected admin panel for adding portfolio projects** |

## Adding portfolio projects (no coding needed)

1. Go to **www.astan-int.lk/admin/** and log in.
2. Click **+ Add project**.
3. Choose **ANTS Design Ventures** (interior design and design projects) or **ASTAN International** (MEP, electrical, construction, property, trade).
4. Enter the title, category, location, year, a short summary and a description.
5. Click **+ Add photos** and select one or more photos. Phone photos are fine because they are resized automatically.
6. Click **Add project**. It appears on the website immediately.

**Before / Design / After (interior projects):** the Photos section has four upload boxes: *General*, *Before*, *Design* (concepts, sketches, 3D renders) and *After*. The project page groups the photos under those headings. When a project has both Before and After photos, it also shows a slider to compare them (the first Before and first After photo, so take them from the same angle). You can change any photo's stage later with its *Stage* dropdown. Projects that don't need stages just use *General*.

Other options:
- **Cover:** pick which photo appears in the portfolio grid.
- **★ Featured:** shows the project first and on the home page.
- **Hide / Publish:** take a project off the site without deleting it.
- **Password:** change the admin password (do this after your first login).

The site comes with **5 sample projects** marked "Sample", so you can see the layout. Delete them in the admin panel once you've added real projects.

## Publishing on GoDaddy

1. GoDaddy → **My Products** → **Web Hosting** → **Manage** → **cPanel Admin** → **File Manager** → open **`public_html`**.
2. Click **Settings** (top right) and tick **Show Hidden Files**.
3. Delete any old placeholder files in `public_html` (e.g. `default.html`, or the old `index.html` from the first version).
4. **Upload** `astan-website-upload.zip`, right-click it → **Extract**. Make sure `index.php` sits directly inside `public_html`, then delete the ZIP.
5. In cPanel → **MultiPHP Manager**, make sure the domain uses **PHP 8.1 or newer**.
6. Visit the site, then go to `/admin/` and log in.

### Updating the site later
Upload the new ZIP the same way. Your projects and photos are stored in `data/projects.json` and `uploads/projects/`. Those are **not** included in the ZIP, so updates never overwrite them.
**Back up** these two folders occasionally (File Manager → select → Compress → Download).

### Contact form email
- Create the mailboxes **info@astan-int.lk** and **info@antsdv.lk** (cPanel → Email Accounts, or GoDaddy / Microsoft 365 email).
- Also create **website@astan-int.lk**, which the form uses as its sender address. You can change this in `includes/config.php` → `MAIL_FROM`. GoDaddy only delivers form mail reliably when the sender address is on your own domain.
- After uploading, send a test message from both contact forms.

### HTTPS (padlock)
1. cPanel → **SSL/TLS Status** → **Run AutoSSL** (free on most plans).
2. Once `https://www.astan-int.lk` works, open `.htaccess` and remove the `# ` from the two lines under **HTTPS**.

### Domains
- **astan-int.lk:** point the domain to the hosting. `.lk` domains are managed at the LK Domain Registry, so set the nameservers or A record there to the values GoDaddy shows for your hosting.
- **antsdv.lk:** in cPanel → **Domains**, add `antsdv.lk` pointing to the same `public_html` folder. Visitors to antsdv.lk are sent to the ANTS pages automatically (see `.htaccess`).
  Alternatively, set up domain forwarding from antsdv.lk to `https://www.astan-int.lk/ants/`.

## Editing text and settings
- **Phone numbers, emails, addresses, registration numbers, WhatsApp number:** `includes/config.php`
- **Service names and descriptions (ASTAN + ANTS):** `includes/services.php`
- **Page text:** `index.php`, `about.php`, `ants/index.php` and the other page files
- **Colours and fonts:** top of `assets/css/site.css`

## Security notes
- `includes/`, `data/` and hidden files are blocked from the web by `.htaccess` files.
- Uploaded photos are checked, re-saved as JPEG (removing hidden data such as GPS location) and stored in `uploads/projects/`, where scripts cannot run.
- After 5 wrong passwords the admin login is locked for 15 minutes.

## Preview on a computer
With PHP installed: run `php -S localhost:8000` in this folder and open http://localhost:8000.
