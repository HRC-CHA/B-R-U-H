#!/bin/bash
set -euo pipefail

cd /var/www/html/my_fuel_project

export FUEL_ENV="${FUEL_ENV:-development}"

echo "[docker-entrypoint] Running database migrations..."
php oil refine migrate

echo "[docker-entrypoint] Starting Apache..."
exec apache2-foreground "$@"
