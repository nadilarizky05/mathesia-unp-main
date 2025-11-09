#!/bin/bash
# Exit immediately if a command exits with a non-zero status.
set -e

# --- CONFIGURATION ---
APP_DIR="/var/www/html/mathesia-unp"
FPM_SERVICE="php8.4-fpm"
LOG_FILE="$APP_DIR/storage/logs/deploy.log"
DATE_TIME=$(date +"%Y-%m-%d %H:%M:%S")
WEB_USER="www-data" # Nginx/PHP-FPM user

# --- FUNCTIONS ---

log_info() {
    echo "[$DATE_TIME] INFO: $1" | tee -a "$LOG_FILE"
}

log_error() {
    echo "[$DATE_TIME] ERROR: $1" | tee -a "$LOG_FILE"
    exit 1
}

# --- INITIAL CHECKS AND SETUP ---

touch "$LOG_FILE" || log_error "Cannot create log file. Check permissions on $APP_DIR/storage/logs"

log_info "====================================================="
log_info "        STARTING PRODUCTION DEPLOYMENT UPDATE        "
log_info "====================================================="

cd "$APP_DIR" || log_error "Failed to change directory to $APP_DIR. Check if the path is correct."

# 1. GIT CLEANUP
if ! git diff-index --quiet HEAD --; then
    log_info "1a. Detected uncommitted changes. Forcing overwrite to match remote..."
    git reset --hard HEAD || log_error "Failed to discard local committed changes."
    git clean -df || log_error "Failed to remove untracked files."
fi

# 2. PULL CODE
log_info "2. Fetching latest code from Git..."
git pull origin main || log_error "Git pull failed. Check network or repository access."

# 3. FIX PERMISSIONS AFTER PULL
log_info "3. Fixing permissions and ownership for web user ($WEB_USER)..."

# Change ownership of all files/directories to $USER:$WEB_USER
sudo chown -R $USER:$WEB_USER "$APP_DIR"

# Set file permissions (read/write for owner/group, read for others)
sudo find "$APP_DIR" -type f -exec chmod 664 {} \;

# Set directory permissions (read/write/execute for owner/group, execute for others)
sudo find "$APP_DIR" -type d -exec chmod 775 {} \;

# Grant execute permission to Node binaries (to fix vite Permission Denied)
sudo chmod +x node_modules/.bin/*

# Ensure critical writable folders have the necessary permissions
sudo chmod -R 775 storage bootstrap/cache

# 4. UPDATE DEPENDENCIES
log_info "4. Installing Composer dependencies..."
sudo -u "$WEB_USER" composer install --no-dev --optimize-autoloader || log_error "Composer install failed."

# 4.5. DUMP AUTOLOAD (NEW LINE ADDED)
log_info "4.5. Dumping Composer autoload files..."
# Run as web user for proper file ownership
sudo -u "$WEB_USER" composer dump-autoload || log_error "Composer dump-autoload failed."

# 5. RUN DATABASE MIGRATIONS
log_info "5. Running database migrations..."
php artisan migrate --force || log_error "Database migration failed. Check DB connection in .env."

# 6. REBUILD FRONTEND ASSETS
log_info "6. Rebuilding frontend assets (Vite/React)..."
# This runs as the SSH user (who now owns node_modules and has +x permission)
npm run build || log_error "Vite build failed."

# 7. CLEAR AND REBUILD CACHES
log_info "7. Clearing and optimizing Laravel caches..."
php artisan optimize:clear
php artisan optimize

# 8. RESTART PHP-FPM SERVICE
log_info "8. Restarting PHP-FPM service ($FPM_SERVICE)..."
sudo systemctl restart "$FPM_SERVICE" || log_error "PHP-FPM restart failed. Check systemctl status."

log_info "====================================================="
log_info "        DEPLOYMENT SUCCESSFUL! 🎉"
log_info "====================================================="