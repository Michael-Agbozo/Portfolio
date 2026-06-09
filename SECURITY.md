# Security Policy

This project is a personal portfolio with a private admin dashboard.

## Sensitive Files

Never commit:

- `.env`
- passwords
- API keys
- SMTP credentials
- database backups with private data

`.env.example` is safe for example values only.

## Dashboard Protection

All dashboard routes must stay behind login.

Guests should not be able to access:

```text
/dashboard/*
```

Security-related dashboard features include:

- Password update.
- Two-factor authentication.
- Error-log viewer.

## Contact Form

The contact form must:

- Validate all fields.
- Save messages safely.
- Send email without exposing private mail credentials.
- Keep the visitor as the reply-to address for owner copies.

## Upload Security

Current upload rules:

- Images only for project, design, media, and profile-photo uploads.
- PDF only for CV upload.
- Validate uploaded files before saving them.
- Do not allow arbitrary file paths from users.

## Database Safety

Do not run destructive commands without clear owner approval:

```bash
php artisan migrate:fresh
php artisan migrate:reset
```

Those commands can erase saved data.

## Reporting Issues

If this project is hosted publicly and someone finds a security issue, they should contact the site owner directly:

```text
michaelsogagbozo@gmail.com
```

Do not publish private security details in a public issue or post.
