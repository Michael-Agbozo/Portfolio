# Portfolio — Project Rules for Claude

## What This Project Is

This is a personal portfolio website built with **Laravel** (a PHP framework). It has two sides:

- **Public side** — what visitors see: your projects, designs, and a contact form.
- **Dashboard** — a private admin area only you can log into. You use it to add/edit/delete projects, upload design images, and read messages people send through the contact form.

---

## How to Run the Project Locally

To start the project on this computer, run:

```
composer run dev
```

That one command starts everything at once (web server, asset builder, log viewer). The site will be available at `http://localhost:8000`.

To set the project up from scratch (first time only):

```
composer run setup
```

---

## Tech Stack (Plain English)

| Thing | What it is |
|---|---|
| **Laravel** | The framework that powers the backend — handles pages, forms, logins, and the database |
| **Blade** | Laravel's template language — the `.blade.php` files are the HTML pages |
| **SQLite** | The database file stored locally at `database/database.sqlite` |
| **Vite** | Bundles the CSS and JavaScript files so the browser can use them |
| **Composer** | PHP's package manager — like an app store for PHP code |
| **npm** | JavaScript's package manager |

---

## Project Map

```
app/
  Http/Controllers/       ← The logic behind each page
    Auth/LoginController  ← Login / logout
    PortfolioController   ← Public home page + contact form
    Dashboard/            ← All admin dashboard actions
  Models/
    Project.php           ← A portfolio project entry
    Design.php            ← A design/image entry
    Message.php           ← A contact form message

resources/
  views/
    home.blade.php        ← The public-facing portfolio page
    auth/login.blade.php  ← Login page
    dashboard/            ← All admin dashboard pages

routes/
  web.php                 ← All URL routes (what URL does what)

database/
  migrations/             ← Instructions for building the database tables
```

---

## How to Communicate With This User

The user has **no background in software development or IT**. Always:

- Use plain, everyday language. No jargon without an explanation.
- When explaining a technical concept, use a real-world analogy first.
- Keep explanations short — one clear sentence beats a paragraph.
- If something could go wrong or cause data loss, say so in plain terms before doing it.
- Never assume the user knows what a terminal, migration, model, controller, or route is.
- If the user asks "what does this do?" — explain it like they're hearing it for the first time.

---

## Common Tasks

### Adding a new field to a model (e.g. adding "description" to Projects)
1. Create a new migration: `php artisan make:migration add_description_to_projects_table`
2. Edit the migration to add the column
3. Run `php artisan migrate`
4. Add the field to `$fillable` in the model
5. Update the form view and controller to handle it

### Creating a new page
1. Add a route in `routes/web.php`
2. Create a controller method
3. Create a Blade view in `resources/views/`

### Changing how the site looks
- Public styles: `resources/css/portfolio.css`
- Dashboard styles: `resources/css/dashboard.css`

---

## Rules Claude Must Follow

### Safety
- **Never delete database migrations** — they are the history of the database structure.
- **Never run `php artisan migrate:fresh` or `migrate:reset`** without explicitly confirming with the user first. These wipe all data.
- **Never commit `.env`** — it contains passwords and secret keys.
- Before running any command that changes the database, explain what it will do in plain English and ask for confirmation.

### Code Style
- Use Laravel conventions: controllers in `app/Http/Controllers/`, models in `app/Models/`, views in `resources/views/`.
- Keep blade templates clean — logic belongs in controllers, not views.
- Validate all form input in the controller before saving to the database.
- Never put raw user input directly into a database query (always use Eloquent or validated data).

### Git
- Commit often with short, clear messages describing what changed in plain English.
- Never force-push to `main`.
- Never commit files from `vendor/`, `node_modules/`, or `.env`.

### Explanations
- When making a change, briefly tell the user **what was changed and why**, not just that it's done.
- If a task requires multiple steps, list them so the user knows what's happening.
- If something fails, explain the error in plain English before suggesting a fix.

---

## Database

- **Engine:** SQLite (file at `database/database.sqlite`)
- **Tables:** `users`, `projects`, `designs`, `messages`, `cache`, `jobs`
- Run `php artisan migrate` to apply any pending database changes.
- Run `php artisan tinker` to interact with the database directly in the terminal (advanced).

---

## Authentication

- There is one admin user. Credentials are set via the database seeder or manually.
- Login page: `/login`
- All dashboard routes are protected — only logged-in users can access them.
- Guests (not logged in) cannot access `/dashboard/*`.
