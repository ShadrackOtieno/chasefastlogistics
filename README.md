# Chase Fast Logistics Limited: Laravel website + back office

Public website and admin back office, built from the company profile.
This folder is an **overlay**: it contains only the files that differ from a fresh Laravel install.

## Requirements
PHP 8.2+, Composer, SQLite/MySQL. Works on Laravel 11 or 12.

## Install (5 minutes)

```bash
# 1. Fresh Laravel app
composer create-project laravel/laravel chasefast
cd chasefast

# 2. Copy everything from this overlay on top of it (accept overwrites of
#    bootstrap/app.php, routes/web.php, routes/console.php,
#    app/Models/User.php, app/Providers/AppServiceProvider.php)

# 3. (optional) set your admin login in .env BEFORE seeding
#    ADMIN_EMAIL=you@chasefastlogistics.com
#    ADMIN_PASSWORD=a-long-unique-password

# 4. Database (MySQL): see "Using MySQL" below, then:
php artisan migrate --seed
php artisan storage:link

# 5. Run
php artisan serve
```

* Website: http://127.0.0.1:8000
* Back office: http://127.0.0.1:8000/admin
  Default login (if you skipped step 3): `admin@chasefastlogistics.com` / `ChangeMe!2026`. Change it under **My account**.
* Demo tracking number: `CFL-DEMO-001` (delete it in the back office before going live).

## Using MySQL / MariaDB
1. Create the database and user: edit the password in `database/mysql-setup.sql`, then run
   `mysql -u root -p < database/mysql-setup.sql` (or create them in phpMyAdmin / cPanel).
2. In your `.env`, replace the `DB_*` lines with the ones in `.env.mysql.example`
   (use the same database name, user and password you just created).
3. Run `php artisan migrate --seed`. This creates all tables and loads the company content.

Needs the `pdo_mysql` PHP extension (enabled on almost all hosts). On shared hosting, use the database
name, user and host that cPanel gives you. The host is often `localhost`.

## Email notifications
New quote requests and contact messages are saved in the database **and** emailed to the address in
**Site settings → Notify email**. In `.env` set real SMTP details (default `MAIL_MAILER=log` only writes to `storage/logs`):

```
MAIL_MAILER=smtp
MAIL_HOST=...        MAIL_PORT=587
MAIL_USERNAME=...    MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=info@chasefastlogistics.com
MAIL_FROM_NAME="Chase Fast Logistics"
```

## What is included

**Front office**: Home, About (vision, mission, values, objectives, team, clients), Services list + detail pages,
Rates, Request a Quote, Track Shipment, Contact, WhatsApp button, SEO titles/descriptions, spam honeypot + rate limiting.

**Back office (/admin)**: Dashboard, Quote requests (status + notes), Contact messages, Shipments with tracking
timeline (adding an update changes the public status), Services, Rates, Clients (logos), Team (photos),
Site settings (all contact details, vision/mission, rates footnote, social links), My account (password change).

## Customising
* Colours: `navy` / `brand` / `teal` in the Tailwind config at the top of `resources/views/layouts/site.blade.php`.
* Logo / hero: `public/images/logo.png`, `public/images/hero.jpg` (cropped from the company profile cover; replace with a higher-resolution logo when you have one).
* Tailwind and Alpine load from CDNs so there is no build step. For production you may prefer to compile Tailwind with the Vite setup Laravel ships.

## Before going live
```bash
APP_ENV=production APP_DEBUG=false   # in .env, plus a real APP_URL
php artisan config:cache && php artisan route:cache && php artisan view:cache
```
Point the web server at `public/`, use HTTPS, and back up the database and `storage/app/public`.
