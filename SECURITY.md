# Security Policy

## Reporting a vulnerability

MicuPanel is a private, self-hosted admin panel. If you discover a security
issue, please report it privately to the maintainer rather than opening a
public issue.

## Hardening built into this application

- **Production config** — `APP_DEBUG=false` and `APP_ENV=production` are
  enforced; stack traces and environment values are never exposed.
- **Authentication** — session login for the UI (public registration is
  disabled) and Sanctum personal access tokens for the API.
- **Authorization** — every project action goes through `ProjectPolicy`.
- **Mass-assignment protection** — all models declare an explicit
  `$fillable`; `$guarded = []` is never used.
- **Input validation** — all writes go through dedicated Form Request
  classes with strict rules (enum, slug, port range, URL).
- **HTTP security headers** — Content-Security-Policy, HSTS, X-Frame-Options,
  X-Content-Type-Options, Referrer-Policy, Permissions-Policy and COOP are
  applied by middleware (and mirrored at the Nginx layer for static assets).
- **HTTPS** — TLS via Certbot, trusted reverse-proxy headers, forced HTTPS
  URL generation, and `Secure` + `HttpOnly` + encrypted session cookies.
- **CSV/formula injection** — spreadsheet exports neutralise `= + - @`
  formula triggers.
- **Rate limiting** — API requests are limited to 60/minute per user.
- **Dependencies** — `composer audit` runs in CI and must pass.

## Keeping it secure

- Run `composer audit` and `composer update` regularly.
- Rotate the API tokens (`php artisan micupanel:token`) periodically.
- Keep the host (Nginx, PHP-FPM, OS packages) patched.
