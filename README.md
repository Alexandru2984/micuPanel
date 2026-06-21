# MicuPanel

[![CI](https://github.com/Alexandru2984/micuPanel/actions/workflows/ci.yml/badge.svg)](https://github.com/Alexandru2984/micuPanel/actions/workflows/ci.yml)
![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

MicuPanel is a private, self-hosted admin panel for managing a VPS / project
ecosystem — a single place to track services, domains, repositories, local
paths, ports, notes, tags, deployment metadata and quick links.

It is login-protected (public registration is disabled) and ships with a
token-authenticated REST API for automation and backups.

## Features

- **Dashboard** — high-level overview of projects, domains and services.
- **Projects** — track paths, stacks, statuses, environments and deployments.
- **Domains & Repositories** — URLs, providers, branches, SSL/Cloudflare flags.
- **Services** — systemd / docker / nginx / php-fpm entries with config hints.
- **Notes & Quick Links** — fast access to Grafana, Sentry, Uptime, docs, etc.
- **Auto-discovery** — scan a directory and import projects automatically.
- **REST API** — Sanctum-authenticated, rate-limited, with JSON/CSV export.

## Tech stack

- Laravel 13 · PHP 8.3+
- SQLite (default; any Laravel-supported database works)
- Laravel Sanctum (API tokens)
- Tailwind CSS · Alpine.js · Vite
- Nginx · PHP-FPM · Certbot (deployment)

## Security highlights

- `APP_DEBUG=false` / `APP_ENV=production` enforced — no stack-trace leaks.
- Explicit `$fillable` on every model (no mass-assignment), Form Request
  validation on all writes, and `ProjectPolicy` authorization.
- Hardened HTTP headers (CSP, HSTS, X-Frame-Options, nosniff, Referrer-Policy,
  Permissions-Policy, COOP) via middleware, mirrored at Nginx.
- HTTPS enforced with trusted proxy headers; `Secure` + `HttpOnly` + encrypted
  session cookies.
- CSV/formula-injection neutralised in exports; API rate limited to 60/min/user.
- `composer audit` runs in CI; see [SECURITY.md](SECURITY.md).

## Getting started

```bash
git clone https://github.com/Alexandru2984/micuPanel.git
cd micuPanel

composer install
npm install

cp .env.example .env
php artisan key:generate

# SQLite (default)
touch database/database.sqlite
php artisan migrate

# Create your login user (registration is disabled)
php artisan micupanel:user you@example.com --name="Your Name"

npm run build
php artisan serve
```

Optionally seed demo data (idempotent): `php artisan db:seed`
(demo login `admin@micupanel.test` / `password`).

## Auto-discovery

Import projects found under a directory:

```bash
php artisan micupanel:discover --dir=/home/you
```

## API

All API endpoints require a Sanctum personal access token and are rate
limited to **60 requests/minute per user**.

Create a token:

```bash
php artisan micupanel:token you@example.com --name=ci
```

Call the API:

```bash
curl -H "Authorization: Bearer <token>" \
     -H "Accept: application/json" \
     https://your-host/api/projects
```

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| `GET` | `/health` | Public liveness probe |
| `GET` | `/api/user` | Current authenticated user |
| `GET` | `/api/projects` | List projects (paginated) |
| `POST` | `/api/projects` | Create a project (validated) |
| `GET` | `/api/projects/{id}` | Show a project with relations |
| `PUT/PATCH` | `/api/projects/{id}` | Update a project (validated) |
| `DELETE` | `/api/projects/{id}` | Delete a project |
| `GET` | `/api/stats` | Aggregate counts |
| `GET` | `/api/tags` · `/api/domains` · `/api/services` | Catalog listings |
| `GET` | `/api/export/projects.json` | Full JSON export |
| `GET` | `/api/export/projects.csv` | CSV export (formula-injection safe) |

## Testing & code quality

```bash
composer test          # PHPUnit (clears config cache first)
vendor/bin/pint        # format code (Laravel Pint)
vendor/bin/pint --test # check formatting without writing
composer audit         # dependency vulnerability scan
```

CI runs linting, the full test suite, a dependency audit and a front-end
build on every push and pull request.

## Deployment

Served by Nginx via PHP-FPM behind Certbot-managed TLS. After deploying:

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

`storage/` and `bootstrap/cache/` must be writable by both the deploy user
and the web server (e.g. `chown -R deploy:www-data` with group write).

## License

MIT — see [LICENSE](LICENSE).
