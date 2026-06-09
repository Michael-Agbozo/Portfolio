# Contributing

This is a personal portfolio project, so contributions are private and controlled by the owner.

## Main Rule

Use:

```text
dev
```

for normal work.

Do not work directly on:

```text
main
```

`main` should only receive changes by merging `dev` into `main` when the owner asks.

## Before Making Changes

Check the current branch and file status:

```bash
git status --short --branch
```

Do not overwrite unrelated changes. If a file already has changes you did not make, read it carefully and work with those changes.

## Coding Rules

- Follow Laravel conventions.
- Put controller logic in `app/Http/Controllers/`.
- Put database models in `app/Models/`.
- Put page templates in `resources/views/`.
- Keep Blade templates clean; avoid putting business logic in views.
- Validate form input before saving it.
- Use Eloquent or validated data for database writes.
- Keep changes small and focused.

## Database Safety

Ask before running any command that changes the database.

Never run these commands without clear confirmation:

```bash
php artisan migrate:fresh
php artisan migrate:reset
```

They can wipe saved data.

Never delete database migrations.

## Files Not To Commit

Do not commit:

- `.env`
- `vendor/`
- `node_modules/`
- private credentials
- one-off local test files

## Testing

Run feature tests after behavior changes:

```bash
php artisan test tests/Feature
```

Use this command because the project may not have a `tests/Unit` folder.

## Commit Style

Use short, plain commit messages.

Good examples:

```text
Add dashboard CV upload
Fix reply email subject spaces
Auto-number new projects
```

## User Communication

The owner is not a software developer. Explain changes in plain language.

Example:

```text
I added a CV upload page in the dashboard. Uploading a PDF there replaces the file used by the public Download CV button.
```
