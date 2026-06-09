# Deployment Guide

This file explains how this portfolio is expected to run on the live server.

## What Deployment Means

Deployment means putting the newest project changes online so visitors can see them.

Think of it like replacing the old printed brochure with a new one. The website code, uploaded assets, database changes, and server settings all need to line up.

## Main Branch Rule

Day-to-day work happens on:

```text
dev
```

The live-ready branch is:

```text
main
```

Only merge `dev` into `main` when the owner asks.

## Production Start Script

The live server uses:

```text
start.sh
```

That script:

- Creates required Nginx log folders.
- Sets writable permissions for Laravel storage and cache.
- Runs database updates with `php artisan migrate --force`.
- Caches Laravel config and routes.
- Creates the public storage link.
- Starts PHP-FPM.
- Builds the Nginx config.
- Adds Laravel routing if missing.
- Adds the upload-size fix if missing.

## Upload Size

Large image uploads need Nginx to allow bigger request bodies.

The project startup script adds:

```nginx
client_max_body_size 64M;
```

Laravel upload limits are:

- Project images: 50 MB.
- Design images: 50 MB.
- Media images: 50 MB.
- Profile photo: 5 MB.
- CV PDF: 10 MB.

If a live upload shows `413 Request Entity Too Large`, Nginx is blocking the file before Laravel receives it.

## Public Files

Important public files:

```text
public/favicon.png
public/apple-touch-icon.png
public/images/michael-hero.png
public/cv/michael-agbozo-cv.pdf
```

The dashboard CV upload replaces:

```text
public/cv/michael-agbozo-cv.pdf
```

## Email Setup

The contact form sends:

- A copy to Michael.
- A confirmation email to the visitor.

The owner inbox is controlled by:

```env
CONTACT_MESSAGE_RECIPIENT="michaelsogagbozo@gmail.com"
```

The server also needs real mail settings, for example SMTP settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Do not commit `.env`. It contains private server settings.

## Database

The project uses SQLite locally:

```text
database/database.sqlite
```

Do not run these commands on live data without clear confirmation:

```bash
php artisan migrate:fresh
php artisan migrate:reset
```

Those commands can wipe data.

## After Deploying

Check these items:

- Homepage loads.
- Dashboard login works.
- Project pages open.
- Contact form stores a message.
- Contact emails send on the live server.
- WhatsApp button opens with the pre-filled message.
- CV download opens `/cv/michael-agbozo-cv.pdf`.
- Uploading an image does not show a `413` error.
- Dashboard logs do not show new errors.

## Useful Commands

Run feature tests locally:

```bash
php artisan test tests/Feature
```

Start local development:

```bash
composer run dev
```
