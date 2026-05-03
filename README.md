# MicuPanel

MicuPanel is a private self-hosted project admin panel for managing my entire VPS/project ecosystem. It is a polished Laravel admin/catalog panel for keeping track of services, domains, repositories, folders, ports, notes, tags, deployment metadata, and quick links.

## Features
- **Dashboard**: High-level overview of projects, domains, and services.
- **Projects**: Keep track of paths, statuses, and deployments.
- **Domains & Repositories**: Track URLs, repo links, and branches.
- **Services**: Keep track of systemd, docker, and nginx configs.
- **Notes & Links**: Fast access to Grafana, Uptime, Sentry, and related notes.
- **Secure**: Login protected, public registration disabled.

## Stack Used
- Laravel 11
- PHP 8.3
- PostgreSQL 16
- Nginx & Certbot
- Tailwind CSS

## How to Install
See `.env.example` to build your environment config. Use Composer and NPM.

## How to run locally on the VPS
The application is served by Nginx via PHP-FPM. There is no need for `php artisan serve` to be running continuously.

## Environment Variables
The application relies on `.env`. See `.env.example` for details. Ensure `APP_ENV=production` and `APP_DEBUG=false`.

## Database Setup
A PostgreSQL database `micupanel` and user `micupanel_user` are configured.

## Systemd Service
This application runs under standard `nginx` and `php8.3-fpm` systemd services.

## Nginx Config Path
`/etc/nginx/sites-available/micupanel` (symlinked to `sites-enabled`)

## Public URL
https://admin.micutu.com

## Data Model Overview
- **Projects**: The core element.
- **Tags, Domains, Repositories, Services, Notes, QuickLinks**: Relationships to Projects.

## API Endpoints
- `GET /health` (Public)
- `GET /api/stats`
- `GET /api/projects`
- `POST /api/projects`
- `PUT /api/projects/{id}`
- `DELETE /api/projects/{id}`
- `GET /api/export/projects.json`
- `GET /api/export/projects.csv`
*(Require auth)*

## Import/Export Notes
Export endpoints dump your project inventory for backups. Be careful not to expose the token.

## Deployment Notes
Deployed automatically by Gemini CLI. 
**Note:** Git commits and pushes are manual and were not done by the agent.

## Security Notes
- **Do not store secrets here.**
- Registration is disabled.
- App is bound locally to FPM.
- SSL enforced via Certbot.

## Limitations / TODOs
- No shell execution in v1.
- No direct log viewing in v1.
- Full UI for CRUD forms requires extending the Blade views further.
