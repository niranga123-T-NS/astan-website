# ASTAN International (Pvt) Ltd — Website

Company website for **ASTAN International (Pvt) Ltd** (Reg. No. PV 00348027), Thalawathugoda, Sri Lanka.
Plain HTML / CSS / JavaScript with a small PHP contact form, so it runs on any GoDaddy cPanel (Linux) hosting plan with no database.

## Files

| File | Purpose |
|------|---------|
| `index.html` | Home page |
| `about.html` | About Us, mission, vision, values, company details |
| `services.html` | All 8 services, grouped into 3 divisions |
| `contact.html` | Contact details, enquiry form, map |
| `404.html` | "Page not found" page |
| `contact.php` | Sends the contact form to `info@astan-int.lk` |
| `assets/css/style.css` | All styling (brand colours are at the top) |
| `assets/js/main.js` | Mobile menu, animations, form messages |
| `assets/img/` | Logo, favicon, background artwork |
| `.htaccess` | 404 page, caching, compression, optional HTTPS redirect |
| `robots.txt`, `sitemap.xml` | Search-engine files |

The header and footer are repeated in each `.html` page — if you change a phone number or menu item, update all five pages.

## Publishing on GoDaddy (cPanel hosting)

1. Download the website as a ZIP (on GitHub: **Code → Download ZIP**), or use `astan-website-upload.zip` if you were given one.
2. Log in to GoDaddy → **My Products** → **Web Hosting** → **Manage** → **cPanel Admin**.
3. Open **File Manager** → go into the **`public_html`** folder.
4. Click **Upload** and upload the ZIP. Then right-click it → **Extract**.
   - Make sure `index.html` ends up directly inside `public_html` (not inside a sub-folder). If it lands in a sub-folder, select everything inside that folder and **Move** it up to `public_html`.
   - Turn on **Settings → Show Hidden Files** so you can see `.htaccess`.
5. Delete the uploaded ZIP and any old `index.php`/`default.html` placeholder page from `public_html`.
6. Visit **www.astan-int.lk** to check the site.

### Email for the contact form
- Create the mailbox **info@astan-int.lk** (cPanel → **Email Accounts**, or GoDaddy / Microsoft 365 email).
- Also create **website@astan-int.lk** (or change `$from` in `contact.php` to another address on your domain). GoDaddy only sends mail reliably when the "From" address is on your own domain.
- Send a test message from the Contact page after uploading.

### HTTPS (padlock)
1. In cPanel, open **SSL/TLS Status** and run **AutoSSL** (free on most GoDaddy plans), or install the SSL certificate from your GoDaddy account.
2. Once `https://www.astan-int.lk` works, open `.htaccess` and remove the `# ` at the start of the 6 marked lines to send all visitors to the secure `https://www.` address.

### Domain
If the domain `astan-int.lk` is registered somewhere other than GoDaddy (`.lk` domains are often registered through the LK Domain Registry), point it to your GoDaddy hosting by updating its nameservers or A record. GoDaddy shows the values in the hosting dashboard.

## Editing
- **Text:** open the `.html` file in any text editor (e.g. Notepad++ or VS Code), change the words between the tags, save and re-upload.
- **Colours:** change `--navy` and `--green` at the top of `assets/css/style.css`.
- **Photos:** add images to `assets/img/` and reference them, e.g. `<img src="assets/img/project1.jpg" alt="Office fit-out">`.

## Preview locally
Open `index.html` in a browser. To test the contact form too, run `php -S localhost:8000` in this folder and visit http://localhost:8000.
