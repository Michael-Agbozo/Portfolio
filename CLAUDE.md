# Portfolio — Project Rules for Claude

## What This Project Is

This is a personal portfolio website built with **Laravel**.

It has two sides:

- **Public side** — visitors see projects, designs, contact options, WhatsApp, and the CV download.
- **Dashboard** — private admin area for projects, designs, media uploads, contact messages, CV upload, profile settings, security, and logs.

## Current Site Features

- Public homepage with design and development work.
- Public project detail pages.
- Active/inactive project toggle; inactive projects are hidden from the public site.
- New project label/number is created automatically.
- Project feature images and gallery images can be uploaded or selected from the media library.
- Design images can be uploaded or selected from the media library.
- Uploaded images are compressed after upload.
- Public CV download uses `/cv/michael-agbozo-cv.pdf`.
- Dashboard has a CV upload page at `/dashboard/cv`.
- Contact form saves messages in the dashboard.
- Contact form emails a copy to `michaelsogagbozo@gmail.com`.
- Contact form sends a confirmation email to the visitor.
- Dashboard reply links use clean email subjects.
- WhatsApp button opens with a simple pre-filled message asking for name, email, and how Michael can help.
- Hero profile image is used for `favicon.png` and `apple-touch-icon.png`.
- Dashboard includes profile photo upload, password change, two-factor authentication, and log viewing.

## How to Run the Project Locally

To start the project on this computer, run:

```bash
composer run dev
```

The site will be available at:

```text
http://localhost:8000
```

To set the project up from scratch:

```bash
composer run setup
```

To run tests:

```bash
php artisan test tests/Feature
```

Use `tests/Feature` because the project may not have a `tests/Unit` folder.

## Tech Stack

| Thing | What it is |
|---|---|
| Laravel | Backend framework |
| Blade | Template language for HTML pages |
| SQLite | Local database at `database/database.sqlite` |
| Vite | Bundles CSS and JavaScript |
| Composer | PHP package manager |
| npm | JavaScript package manager |
| Nginx | Production web server |

## Project Map

```text
app/
  Http/Controllers/
    Auth/LoginController.php
    PortfolioController.php
    Dashboard/
      CvController.php
      DashboardController.php
      DesignController.php
      LogController.php
      MediaController.php
      MessageController.php
      ProfileController.php
      ProjectController.php
      TwoFactorController.php
  Mail/
    ContactMessageConfirmation.php
    ContactMessageReceived.php
  Models/
    Design.php
    Media.php
    Message.php
    Project.php
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
```

## How to Communicate With This User

The user has **no background in software development or IT**. Always:

- Use plain, everyday language.
- Explain technical ideas with a real-world analogy first.
- Keep explanations short.
- Say plainly if something could cause data loss.
- Never assume the user knows what terminal, migration, model, controller, or route means.
- If the user asks "what does this do?", explain it like they are hearing it for the first time.

## Common Tasks

### Adding a new field to a model

1. Create a migration.
2. Edit the migration.
3. Ask before running `php artisan migrate`, because it changes the database.
4. Add the field to `$fillable` in the model.
5. Update the controller validation.
6. Update the Blade form.
7. Add or update focused tests.

### Creating a dashboard page

1. Add a controller in `app/Http/Controllers/Dashboard/`.
2. Add routes inside the authenticated dashboard group in `routes/web.php`.
3. Add a Blade view under `resources/views/dashboard/`.
4. Add navigation or settings tab if needed.
5. Add a feature test.

### Changing public styling

- Public styles are mainly in `resources/css/app.css` and `resources/css/portfolio.css`.
- Dashboard styles are in `resources/css/dashboard.css`.

## Upload Rules

- Project, design, and media image uploads allow up to 100 MB each (150 MB total for multi-file uploads).
- Profile photo upload allows up to 5 MB.
- CV upload allows PDF files up to 10 MB.
- Image uploads should go through `ImageCompressor` when they are saved.
- Nginx upload size is handled in `start.sh` with `client_max_body_size 170M;`.

## Email Rules

- Contact messages must still be saved in the dashboard.
- A copy should be emailed to `config('mail.contact_recipient')`.
- The default recipient is `michaelsogagbozo@gmail.com`.
- Visitors receive `ContactMessageConfirmation`.
- Owner copies use `ContactMessageReceived` and should keep the visitor as reply-to.
- Do not commit `.env`; use `.env.example` for safe example values.

## Safety

- **Never delete the `main` or `dev` branches**, locally or on GitHub.
- **Never delete database migrations**.
- **Never run `php artisan migrate:fresh` or `php artisan migrate:reset`** without clearly confirming with the user first.
- **Never commit `.env`**.
- Before running any command that changes the database, explain what it will do in plain English and ask for confirmation.
- Do not force-push to `main`.
- Do not commit files from `vendor/`, `node_modules/`, or `.env`.

## Code Style

- Follow Laravel conventions.
- Keep logic in controllers or support classes, not Blade views.
- Validate form input in controllers before saving.
- Use Eloquent or validated data for database writes.
- Keep changes small and focused.
- Add tests for behavior changes.

## Git

- Work on `dev` for day-to-day changes.
- Commit often with short, clear messages.
- Never commit directly to `main`.
- Only merge `dev` into `main` when the user asks.
- Do not merge `main` into other branches as a routine update path.

## Database

- Engine: SQLite.
- File: `database/database.sqlite`.
- Tables include `users`, `projects`, `designs`, `messages`, `media`, `cache`, and `jobs`.

## Authentication

- Login page: `/login`.
- Dashboard routes are protected.
- Guests cannot access `/dashboard/*`.
