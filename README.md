# WebOne

WordPress project prepared for local development with [LocalWP](https://localwp.com/).

This repository contains a full Local site structure, including:

- WordPress core in `app/public`
- Custom child theme in `app/public/wp-content/themes/webone-agency`
- Local database dump in `app/sql/local.sql`
- Local server templates in `conf/`

The database dump is configured for the site URL `http://webone.local`.

## Project structure

```text
.
├── app/
│   ├── public/   # WordPress installation
│   └── sql/      # Local database export
├── conf/         # LocalWP service templates
└── logs/         # Local runtime logs (ignored in git)
```

## Local setup with LocalWP

### 1. Install LocalWP

Install Local from [https://localwp.com/](https://localwp.com/).

### 2. Clone this repository into your Local Sites directory

On macOS, Local usually stores sites in:

```bash
~/Local Sites/
```

Clone the repository so the final path is:

```bash
~/Local Sites/webone
```

Example:

```bash
git clone https://github.com/KaushikShee/webone.git "~/Local Sites/webone"
```

### 3. Open or create the site in Local

Create a Local site named `webone` so the local domain matches the database dump:

```text
http://webone.local
```

If Local generates the site directory for you first, stop the site and replace that generated folder with this repository contents.

### 4. Start the site services

After Local recognizes the site, start the environment from the Local app.

This project already uses the standard Local database credentials in `app/public/wp-config.php`:

```php
DB_NAME=local
DB_USER=root
DB_PASSWORD=root
DB_HOST=localhost
```

### 5. Import the database

Import the included dump:

```text
app/sql/local.sql
```

You can import it using Local's database tool or Adminer/phpMyAdmin if enabled in your Local setup.

### 6. Verify the site

Once the database is imported and the site is running, open:

- Frontend: `http://webone.local`
- Admin: `http://webone.local/wp-admin`

## Theme details

The main custom work in this project lives in:

- `app/public/wp-content/themes/webone-agency/style.css`
- `app/public/wp-content/themes/webone-agency/functions.php`
- `app/public/wp-content/themes/webone-agency/theme.json`
- `app/public/wp-content/themes/webone-agency/templates/`
- `app/public/wp-content/themes/webone-agency/patterns/`

The custom theme is `WebOne Agency`, a child theme of `twentytwentyfive`.

## Notes

- This repository includes the full WordPress install, not just the custom theme.
- Local runtime logs are excluded from git via `.gitignore`.
- If you create the site with a domain other than `webone.local`, run a search-replace in the database before using the site.
