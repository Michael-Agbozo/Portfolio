# Michael Agbozo Portfolio

This is Michael Agbozo's personal portfolio website built with Laravel.

The site has two main areas:

- **Public portfolio**: projects, designs, contact form, WhatsApp shortcut, and CV download.
- **Admin dashboard**: private area for managing projects, design uploads, media files, messages, profile photo, security, logs, and the public CV.

## Local Setup

Start the project locally:

```bash
composer run dev
```

The site opens at:

```text
http://localhost:8000
```

First-time setup:

```bash
composer run setup
```

Run feature tests:

```bash
php artisan test tests/Feature
```

The default `php artisan test` command may complain if `tests/Unit` does not exist, so use the feature-test command above.

## Tech Stack

| Tool | Purpose |
|---|---|
| Laravel | Backend framework |
| Blade | HTML templates |
| SQLite | Local database at `database/database.sqlite` |
| Vite | CSS and JavaScript bundling |
| Composer | PHP package manager |
| npm | JavaScript package manager |
| Nginx | Production web server |

## Important URLs

| Area | URL |
|---|---|
| Public site | `/` |
| Project detail | `/projects/{project-slug}` |
| Login | `/login` |
| Dashboard | `/dashboard` |
| Projects | `/dashboard/projects` |
| Designs | `/dashboard/designs` |
| Media library | `/dashboard/media` |
| Messages | `/dashboard/messages` |
| Settings | `/dashboard/profile` |
| CV upload | `/dashboard/cv` |
| Logs | `/dashboard/logs` |
| Security | `/dashboard/security` |

## Current Features

- Public project sections for design and development work.
- Project detail pages use slugs, such as `/projects/project-name`.
- Projects can be marked active or inactive; inactive projects are hidden from the public site.
- New projects are numbered automatically.
- Design and project image uploads are compressed after upload.
- Media library supports reusable uploaded images.
- Contact form saves messages in the dashboard.
- Contact form sends a copy to `michaelsogagbozo@gmail.com`.
- Contact form sends an automatic confirmation email to the visitor.
- Dashboard message reply links open email with a clean subject line.
- Floating WhatsApp button opens with a pre-filled intro:

```text
Hi Michael, I found your portfolio and I'd like to reach out.

Name:
Email:
How can you help me:
```

- Public CV download points to `/cv/michael-agbozo-cv.pdf`.
- Dashboard CV page lets the admin upload a new PDF CV.
- Hero profile image is used as the favicon and Apple touch icon.
- Two-factor authentication is available from dashboard security settings.
- Dashboard has profile photo upload and password update.
- Dashboard has an error-log viewer.

## Uploads

Image uploads are validated in Laravel and compressed with `App\Support\ImageCompressor`.

Current upload limits:

- Project images: up to 50 MB each.
- Design images: up to 50 MB each.
- Media library images: up to 50 MB each.
- Profile photo: up to 5 MB.
- CV upload: PDF only, up to 10 MB.

Production Nginx is configured in `start.sh` to allow larger uploads with:

```nginx
client_max_body_size 64M;
```

## Email

The contact form sends two emails:

- One copy to the site owner.
- One confirmation email to the visitor.

The owner recipient defaults to:

```text
michaelsogagbozo@gmail.com
```

It can be changed with:

```env
CONTACT_MESSAGE_RECIPIENT="michaelsogagbozo@gmail.com"
```

For live email delivery, the server must have real mail settings. The default `.env.example` uses log mail, which writes emails to logs instead of sending them.

## Project Map

```text
app/
  Http/Controllers/
    Auth/                         Login and logout
    Dashboard/                    Admin dashboard actions
      CvController.php            CV upload page
      MediaController.php         Media library uploads
      ProjectController.php       Project create/edit/delete
      DesignController.php        Design create/edit/delete
      MessageController.php       Contact messages
      ProfileController.php       Profile photo and password
      TwoFactorController.php     Two-factor authentication
    PortfolioController.php       Public site and contact form
  Mail/
    ContactMessageReceived.php    Email copy to Michael
    ContactMessageConfirmation.php Auto reply to visitor
  Models/
    Project.php
    Design.php
    Message.php
    Media.php
    User.php
  Support/
    ImageCompressor.php
    ImagePathValidator.php

resources/
  views/
    home.blade.php
    project.blade.php
    emails/
    dashboard/
  css/
    app.css
    portfolio.css
    dashboard.css

routes/
  web.php

public/
  images/michael-hero.png
  favicon.png
  apple-touch-icon.png
  cv/michael-agbozo-cv.pdf

database/
  migrations/
  seeders/

tests/
  Feature/
```

## Database

The local database is SQLite:

```text
database/database.sqlite
```

Important tables:

- `users`
- `projects`
- `designs`
- `messages`
- `media`
- `cache`
- `jobs`

To apply pending database changes:

```bash
php artisan migrate
```

Do not run destructive database reset commands unless you are intentionally wiping local data.

## Deployment Notes

The production start script is `start.sh`.

It:

- Prepares storage and cache folders.
- Runs migrations with `php artisan migrate --force`.
- Caches config and routes.
- Ensures the storage link exists.
- Starts PHP-FPM and Nginx.
- Adds Laravel routing if missing.
- Adds the larger Nginx upload limit if missing.

## Git Workflow

Day-to-day work happens on `dev`.

`main` should only receive changes by merging `dev` into `main` when the owner asks for it.
