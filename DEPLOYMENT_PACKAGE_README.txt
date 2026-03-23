================================================================================
COURIER SAVINGS BANK - DEPLOYMENT PACKAGE
================================================================================

PACKAGE CONTENTS:
-----------------
1. courier-savings-bank-deployment.zip (32MB) - Complete Laravel application
2. database_mysql_fixed.sql - MySQL schema + demo/admin seed (password="password")
3. CPANEL_DEPLOYMENT_GUIDE.md - Step-by-step deployment instructions
4. EMAIL_SETUP_GUIDE.md - Email configuration guide

================================================================================
QUICK START GUIDE
================================================================================

STEP 1: UPLOAD FILES TO CPANEL
-------------------------------
1. Extract courier-savings-bank-deployment.zip on your computer
2. Upload ALL files (except public folder) to: public_html/banking-app/
3. Upload contents of public folder to: public_html/
4. Set folder permissions:
   - storage/ → 775
   - bootstrap/cache/ → 775

STEP 2: CREATE & IMPORT DATABASE
---------------------------------
1. In cPanel → MySQL Databases:
   - Create database: youruser_courierbank
   - Create user: youruser_bankuser
   - Add user to database with ALL PRIVILEGES

2. In phpMyAdmin:
   - Select your database
   - Click "Import" tab
   - Upload database_mysql_fixed.sql
   - Click "Go"

STEP 3: CONFIGURE ENVIRONMENT
------------------------------
1. In public_html/banking-app/ create .env file
2. Copy contents from .env.example
3. Update these values:
   - APP_KEY=base64:YOUR_KEY_HERE (generate with: php artisan key:generate)
   - APP_URL=https://yourdomain.com
   - DB_DATABASE=youruser_courierbank
   - DB_USERNAME=youruser_bankuser
   - DB_PASSWORD=your_database_password
   - MAIL_HOST=mail.yourdomain.com
   - MAIL_USERNAME=noreply@yourdomain.com
   - MAIL_PASSWORD=your_email_password
   - MAIL_FROM_ADDRESS=noreply@yourdomain.com

STEP 4: UPDATE INDEX.PHP
-------------------------
Edit public_html/index.php and update paths to point to ../banking-app/
(See CPANEL_DEPLOYMENT_GUIDE.md for exact code)

STEP 5: CREATE .HTACCESS FILES
-------------------------------
1. public_html/.htaccess (for Laravel routing)
2. public_html/banking-app/.htaccess (to protect Laravel folder)
(See CPANEL_DEPLOYMENT_GUIDE.md for exact code)

STEP 6: SETUP EMAIL
-------------------
1. In cPanel → Email Accounts
2. Create: noreply@yourdomain.com
3. Note the mail server settings
4. Update .env with email credentials

STEP 7: TEST YOUR INSTALLATION
-------------------------------
1. Visit: https://yourdomain.com
2. Register a new account
3. Check if welcome email arrives
4. Login to dashboard
5. Test deposit/withdrawal
6. Login as admin:
   - Email: admin@bankapp.com
   - Password: password
   - CHANGE THIS PASSWORD IMMEDIATELY!

================================================================================
IMPORTANT SECURITY NOTES
================================================================================

✓ Set APP_DEBUG=false in production
✓ Use strong APP_KEY (generate with php artisan key:generate)
✓ Use strong database password
✓ Use strong email password
✓ Change admin password immediately after first login
✓ Enable HTTPS/SSL certificate
✓ Set proper file permissions (755 for folders, 644 for files)
✓ Ensure .env file is not web-accessible

================================================================================
SYSTEM REQUIREMENTS
================================================================================

- PHP 8.1 or higher
- MySQL 5.7 or higher
- cPanel hosting account
- Domain with SSL certificate
- Email account for notifications

================================================================================
DEFAULT ADMIN CREDENTIALS
================================================================================

Email: admin@bankapp.com
Password: password
User ID: USR10001

⚠️ CHANGE THESE CREDENTIALS IMMEDIATELY AFTER FIRST LOGIN!

================================================================================
FEATURES INCLUDED
================================================================================

✓ User registration and authentication
✓ Account management (savings accounts)
✓ Deposit and withdrawal transactions
✓ Send money to other accounts
✓ Beneficiary management
✓ Recurring transfers
✓ Bill payments with saved payees
✓ Virtual debit cards (Visa/Mastercard)
✓ Transaction history and statements
✓ PDF statement generation
✓ Email notifications (welcome, transactions, tax alerts, account freeze)
✓ Admin dashboard with user management
✓ Tax & IRS controls
✓ Account freeze/unfreeze functionality
✓ KYC verification system
✓ Profile management
✓ Password reset functionality
✓ Static pages (Contact, Privacy, Terms, About, Personal Banking)

================================================================================
EMAIL NOTIFICATIONS
================================================================================

The system sends emails for:
- New account registration (Welcome email)
- All transactions (deposits, withdrawals, transfers)
- Tax alerts from IRS
- Account frozen/unfrozen notifications
- Password reset requests

Ensure your email is properly configured in .env file!

================================================================================
SUPPORT & TROUBLESHOOTING
================================================================================

If you encounter issues:

1. Check cPanel error logs
2. Check Laravel logs: storage/logs/laravel.log
3. Temporarily enable debug: APP_DEBUG=true (disable after fixing)
4. Verify database credentials in .env
5. Verify email credentials in .env
6. Check file permissions
7. Clear browser cache
8. Ensure PHP version is 8.1+

Common Issues:
- 500 Error: Check .env file and file permissions
- Blank Page: Check index.php paths
- CSS/JS not loading: Check APP_URL in .env
- Emails not sending: Check MAIL_* settings in .env
- Database error: Check DB_* credentials in .env

================================================================================
POST-DEPLOYMENT CHECKLIST
================================================================================

□ Change admin password
□ Test all email notifications
□ Configure backup schedule in cPanel
□ Set up SSL certificate
□ Test all features thoroughly
□ Monitor error logs for first few days
□ Enable OPcache in cPanel PHP settings
□ Consider using Cloudflare for CDN
□ Set up cron jobs for scheduled tasks (optional)

================================================================================
BACKUP STRATEGY
================================================================================

1. Use cPanel's backup feature
2. Schedule automatic backups
3. Download backups regularly
4. Test restore process
5. Keep backups in multiple locations

================================================================================
PERFORMANCE OPTIMIZATION
================================================================================

1. Enable OPcache in cPanel PHP settings
2. Use cPanel's built-in caching
3. Enable Gzip compression
4. Consider using Cloudflare for CDN
5. Optimize images before upload
6. Monitor resource usage

================================================================================
ADDITIONAL DOCUMENTATION
================================================================================

For detailed instructions, please refer to:
- CPANEL_DEPLOYMENT_GUIDE.md (Complete deployment guide)
- EMAIL_SETUP_GUIDE.md (Email configuration)
- README.md (Application overview)

================================================================================
VERSION INFORMATION
================================================================================

Application: Courier Savings Bank
Version: 1.0.0
Laravel Version: 11.x
PHP Version: 8.3+
Database: MySQL
Build Date: March 18, 2026

================================================================================
CONTACT & SUPPORT
================================================================================

For technical support or questions about the application:
- Check the documentation files included in this package
- Review Laravel documentation: https://laravel.com/docs
- Check cPanel documentation for hosting-specific issues

================================================================================
LICENSE & COPYRIGHT
================================================================================

Courier Savings Bank
© 2026 All Rights Reserved

This application is provided as-is for deployment on your cPanel hosting.
Ensure you comply with all applicable banking and financial regulations
in your jurisdiction.

================================================================================
END OF DEPLOYMENT PACKAGE README
================================================================================
