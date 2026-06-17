# Deployment (No Artisan On Server)

This project can be deployed to a shared host where Artisan, Composer, and npm are not available.

## What this package already includes

- PHP dependencies in vendor/
- Built frontend assets in public/build/
- A production-ready environment file template

## Server requirements

- PHP 8.1+
- MySQL 8+ or compatible
- Web root pointed to public/
- Writable directories:
	- storage/
	- bootstrap/cache/

## Upload steps

1. Upload and extract the zip on the server.
2. Ensure the project root contains all files and folders.
3. Set your domain document root to the extracted public/ directory.
4. Use .env.production.ready as your live .env (rename or copy contents).
5. Confirm DB credentials in .env match your host database.

## Permissions

Set write permissions for:

- storage/
- storage/framework/cache/
- storage/framework/sessions/
- storage/framework/views/
- storage/logs/
- bootstrap/cache/

## Important notes

- No Artisan commands are required for first launch.
- Do not expose .env publicly.
- If your hosting panel cannot point directly to public/, move public/index.php and public/.htaccess to your web root and update paths in index.php.

## Smoke test checklist

- Home page loads at https://arize18.co.za/
- Booking page opens and submits
- Admin/auth pages open
- CSS/JS loads (no missing asset errors)
- storage/logs/laravel.log is being written
