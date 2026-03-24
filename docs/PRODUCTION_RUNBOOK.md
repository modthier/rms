# Production Runbook

## 1) Server prerequisites

- PHP 8.2+
- MySQL 8+
- Redis (cache + queue)
- Nginx + PHP-FPM
- Supervisor (queue workers)
- Cron enabled

## 2) First deployment

1. Copy project code to server.
2. Create `.env` from `.env.production.example`.
3. Set real secrets and DB credentials.
4. Install dependencies:
   - `composer install --no-dev --optimize-autoloader`
5. Generate app key:
   - `php artisan key:generate`
6. Run migrations:
   - `php artisan migrate --force`
7. Cache framework config:
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan view:cache`

## 3) Queue + scheduler

- Start queue workers with Supervisor:
  - `php artisan queue:work --sleep=1 --tries=3 --timeout=90`
- Example Supervisor config:
  - `docs/SUPERVISOR_QUEUE_EXAMPLE.conf`
- Add cron entry:
  - `* * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1`

## 4) Health checks

- Liveness: `GET /health/live`
- Readiness: `GET /health/ready`

Use these endpoints in your load balancer / uptime monitor.

## 5) Release checklist

- `APP_ENV=production`
- `APP_DEBUG=false`
- HTTPS enabled
- Reverse proxy forwards `X-Forwarded-*` headers correctly
- Queue worker running
- Scheduler running
- Logs writable
- Backups configured
- Smoke tests pass on production

## 6) Rollback basics

1. Keep previous release directory available.
2. Switch web root/symlink back to previous release.
3. Re-run cache commands.
4. Restart PHP-FPM + queue workers.

