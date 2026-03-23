# cPanel Deployment Guide - Courier Savings Bank

## Prerequisites
- cPanel hosting account with PHP 8.1+ and MySQL 5.7+
- Domain name configured
- FTP/File Manager access
- MySQL database access via phpMyAdmin

---

## No SSH / no terminal on cPanel (File Manager only)

You **do not** need Composer, npm, or `php artisan` **on the server** if you upload a package that already includes **`vendor/`** and built assets in **`public/build/`**.

1. **Use this archive** (from your computer project folder): **`courierbank-upload-with-vendor.zip`**  
   - Includes `vendor/` (PHP dependencies) — no `composer install` on cPanel.  
   - Still **excludes** `node_modules/` (not needed on the server; CSS/JS are already in `public/build/`).

2. **Upload & extract** in cPanel → **File Manager** → `public_html` (or your subdomain folder) → **Upload** the zip → **Extract**.

3. **Move files** to match the layout in this guide (Laravel app in `banking-app/`, `public` contents in `public_html/` or document root). See **Step 2** and **Step 5** (`index.php` paths).

4. **Create `.env`** in `banking-app/` using **File Manager → Edit** (copy from `.env.example` and fill in DB + mail).  
   - **`APP_KEY`**: you must set this once. Easiest on **your PC** (where you have PHP): open a terminal in the project folder and run `php artisan key:generate`, then copy `APP_KEY=` from your local `.env` into the server `.env`.  
   - If you truly have no terminal anywhere: ask your host if they offer **“Terminal”** or **“Composer”** in cPanel (some do), or use another computer with PHP for one command.

5. **Database**: use **phpMyAdmin** → **Import** → `database_mysql_fixed.sql` (no `php artisan migrate` required if the import matches the app).

6. **Permissions** (File Manager → right‑click folder → **Permissions**): `storage` and `bootstrap/cache` → **775** (or `755` if your host disallows 775).

7. **Optional**: If your host offers **Terminal** or **Composer** later, you can run `php artisan config:cache` for performance — not required for the site to load.

---

## Step 1: Prepare Your Files

### 1.1 Build Assets Locally (Before Upload)
Run these commands on your local machine:

```bash
npm install
npm run build
```

This creates optimized CSS/JS files in `public/build/`

### 1.2 Generate Application Key
```bash
php artisan key:generate
```

Copy the generated key from `.env` file (starts with `base64:`)

---

## Step 2: Upload Files to cPanel

### 2.1 File Structure on cPanel
```
public_html/              (Your domain root)
├── index.php            (from public folder)
├── .htaccess            (from public folder)
├── build/               (from public/build)
├── logo.svg
├── favicon.svg
└── banking-app/         (All other Laravel files)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    └── ...
```

### 2.2 Upload Steps
1. Upload ALL files EXCEPT `public` folder to `public_html/banking-app/`
2. Upload contents of `public` folder to `public_html/`
3. Set permissions:
   - `storage/` folder: 775
   - `bootstrap/cache/` folder: 775

---

## Step 3: Create MySQL Database

### 3.1 In cPanel MySQL Databases
1. Create new database: `youruser_courierbank`
2. Create new user: `youruser_bankuser`
3. Set strong password
4. Add user to database with ALL PRIVILEGES

### 3.2 Import Database
1. Go to phpMyAdmin
2. Select your database
3. Click "Import" tab
4. Upload `database_mysql_fixed.sql` file
5. Click "Go"

---

## Step 3.3: SSL / HTTPS (required for a secure site)

SSL certificates are **installed in cPanel** (AutoSSL / Let’s Encrypt), not inside PHP. After the certificate is active:

1. Open **SSL/TLS Status** in cPanel and ensure your domain shows as secure.
2. In your Laravel `.env` (see Step 4), set:
   - `APP_URL=https://yourdomain.com` (must use `https://`)
   - `FORCE_HTTPS=true`
   - `SESSION_SECURE_COOKIE=true`
3. The app is configured to use HTTPS URLs and trust proxy headers (`X-Forwarded-Proto`) common on shared hosting.

> **Note:** Chrome “Dangerous site” warnings are often from **Google Safe Browsing** (phishing/malware reputation), not only missing SSL. You still need a valid certificate **and** a clean domain reputation.

---

## Step 4: Configure Environment

### 4.1 Create .env File
In `public_html/banking-app/` create `.env` file:

```env
APP_NAME="Courier Savings Bank"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://yourdomain.com
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=youruser_courierbank
DB_USERNAME=youruser_bankuser
DB_PASSWORD=your_database_password

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

# Email Configuration (IMPORTANT!)
MAIL_MAILER=smtp
MAIL_HOST=mail.couriersavingsbank.com
MAIL_PORT=587
MAIL_USERNAME=info@couriersavingsbank.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@couriersavingsbank.com"
MAIL_FROM_NAME="Courier Savings Bank"

VITE_APP_NAME="${APP_NAME}"
```

### 4.2 Important: Update These Values
- `APP_KEY`: Your generated application key
- `APP_URL`: Your actual domain
- `DB_DATABASE`: Your database name
- `DB_USERNAME`: Your database username
- `DB_PASSWORD`: Your database password
- `MAIL_HOST`: Your cPanel mail server (usually mail.yourdomain.com)
- `MAIL_USERNAME`: Email account you created
- `MAIL_PASSWORD`: Email password
- `MAIL_FROM_ADDRESS`: Your sending email

---

## Step 5: Update index.php

Edit `public_html/index.php`:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../banking-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../banking-app/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../banking-app/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

---

## Step 6: Create .htaccess Files

### 6.1 Root .htaccess (public_html/.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect to HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 6.2 Protect Laravel Folder (public_html/banking-app/.htaccess)
```apache
# Deny all access to Laravel folder
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order deny,allow
    Deny from all
</IfModule>
```

---

## Step 7: Set Up Email in cPanel

### 7.1 Create Email Account
1. Go to cPanel → Email Accounts
2. Create: `noreply@yourdomain.com`
3. Set strong password
4. Note the mail server settings

### 7.2 Test Email Configuration
The system will send emails for:
- New account registration
- Transaction confirmations
- Account frozen/unfrozen
- Tax alerts
- Password resets

---

## Step 8: Configure Cron Jobs (Optional but Recommended)

In cPanel → Cron Jobs, add:

```
* * * * * cd /home/youruser/public_html/banking-app && php artisan schedule:run >> /dev/null 2>&1
```

This runs Laravel's task scheduler every minute.

---

## Step 9: Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong `APP_KEY`
- [ ] Use strong database password
- [ ] Use strong email password
- [ ] Enable HTTPS/SSL certificate
- [ ] Set proper file permissions (755 for folders, 644 for files)
- [ ] Protect `.env` file (should not be web-accessible)
- [ ] Enable cPanel security features (ModSecurity, etc.)

---

## Step 10: Test Your Installation

### 10.1 Test Pages
- [ ] Homepage: https://yourdomain.com
- [ ] Register: https://yourdomain.com/register
- [ ] Login: https://yourdomain.com/login
- [ ] Contact: https://yourdomain.com/contact

### 10.2 Test Functionality
1. Register a new account
2. Check if welcome email arrives
3. Login to dashboard
4. Test deposit/withdrawal
5. Test admin login (admin@bankapp.com / password)

---

## Troubleshooting

### Issue: 500 Internal Server Error
**Solution:**
- Check `.env` file exists and is configured
- Check file permissions (storage and bootstrap/cache need 775)
- Check error logs in cPanel

### Issue: Blank Page
**Solution:**
- Check `index.php` paths are correct
- Verify `vendor` folder was uploaded
- Check PHP version (needs 8.1+)

### Issue: CSS/JS Not Loading
**Solution:**
- Verify `public/build` folder was uploaded
- Check `APP_URL` in `.env` matches your domain
- Clear browser cache

### Issue: Emails Not Sending
**Solution:**
- Verify email account exists in cPanel
- Check MAIL_* settings in `.env`
- Test email in cPanel webmail first
- Check spam folder

### Issue: Database Connection Error
**Solution:**
- Verify database credentials in `.env`
- Check database user has privileges
- Confirm database exists

---

## Admin Access

**Default Admin Account:**
- Email: admin@bankapp.com
- Password: password

**IMPORTANT:** Change this password immediately after first login!

---

## Support

For issues:
1. Check cPanel error logs
2. Check Laravel logs: `storage/logs/laravel.log`
3. Enable debug mode temporarily: `APP_DEBUG=true` (remember to disable after)

---

## Post-Deployment Tasks

1. [ ] Change admin password
2. [ ] Test all email notifications
3. [ ] Configure backup schedule in cPanel
4. [ ] Set up SSL certificate
5. [ ] Test all features thoroughly
6. [ ] Monitor error logs for first few days

---

## File Checklist

Files you need to upload:
- [ ] All Laravel files (in banking-app folder)
- [ ] Public folder contents (to public_html root)
- [ ] .env file (configured)
- [ ] .htaccess files (both locations)
- [ ] database_mysql_fixed.sql (import via phpMyAdmin)

---

## Performance Optimization

1. Enable OPcache in cPanel PHP settings
2. Use cPanel's built-in caching
3. Enable Gzip compression
4. Consider using Cloudflare for CDN

---

## Backup Strategy

1. Use cPanel's backup feature
2. Schedule automatic backups
3. Download backups regularly
4. Test restore process

---

## Success!

Your Courier Savings Bank application should now be live and fully functional on cPanel!

Visit: https://yourdomain.com
