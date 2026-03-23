# Email Configuration Guide

## cPanel Email Setup

### Step 1: Create Email Account in cPanel

1. Login to cPanel
2. Go to "Email Accounts"
3. Click "Create"
4. Fill in:
   - Email: `noreply@yourdomain.com`
   - Password: (strong password)
   - Mailbox Quota: 250 MB (or unlimited)
5. Click "Create"

### Step 2: Get Email Settings

After creating the email, note these settings:
- **Incoming Server:** mail.yourdomain.com
- **IMAP Port:** 993 (SSL)
- **POP3 Port:** 995 (SSL)
- **Outgoing Server (SMTP):** mail.yourdomain.com
- **SMTP Port:** 587 (TLS) or 465 (SSL)
- **Username:** noreply@yourdomain.com
- **Password:** (your email password)

### Step 3: Update .env File

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Courier Savings Bank"
```

**Important Notes:**
- Use port 587 with TLS (recommended)
- Or use port 465 with SSL
- Never use port 25 (often blocked)
- Username is the full email address

### Step 4: Test Email Configuration

#### Option 1: Test via Registration
1. Register a new account
2. Check if welcome email arrives
3. Check spam folder if not in inbox

#### Option 2: Test via Contact Form
1. Go to /contact page
2. Fill out and submit form
3. Check if email arrives

### Step 5: Troubleshooting

#### Emails Not Sending?

**Check 1: Verify Email Account**
- Login to webmail: https://yourdomain.com:2096
- Try sending a test email from webmail
- If webmail works, issue is with Laravel config

**Check 2: Verify .env Settings**
```bash
# Check these match exactly:
MAIL_HOST=mail.yourdomain.com  # NOT smtp.yourdomain.com
MAIL_PORT=587                   # TLS port
MAIL_USERNAME=noreply@yourdomain.com  # Full email
MAIL_ENCRYPTION=tls             # Lowercase
```

**Check 3: Check Laravel Logs**
- Location: `storage/logs/laravel.log`
- Look for email-related errors
- Common errors:
  - "Connection refused" = Wrong host/port
  - "Authentication failed" = Wrong username/password
  - "Connection timed out" = Firewall/port blocked

**Check 4: Test SMTP Connection**
You can test SMTP from command line:
```bash
telnet mail.yourdomain.com 587
```
Should connect successfully.

#### Common Issues

**Issue: "Connection refused"**
- Solution: Check MAIL_HOST is correct (mail.yourdomain.com)
- Solution: Try port 465 with SSL instead

**Issue: "Authentication failed"**
- Solution: Verify email account exists in cPanel
- Solution: Check password is correct (no spaces)
- Solution: Use full email as username

**Issue: "Connection timed out"**
- Solution: Check if port 587 is open
- Solution: Contact hosting provider
- Solution: Try port 465 instead

**Issue: Emails go to spam**
- Solution: Set up SPF record in cPanel DNS
- Solution: Set up DKIM in cPanel
- Solution: Use proper FROM address

### Step 6: Email Notifications in System

The system sends emails for:

1. **Welcome Email** - When user registers
2. **Transaction Notifications** - Deposits, withdrawals, transfers
3. **Tax Alert** - When admin sets tax obligation
4. **Account Frozen** - When admin freezes account
5. **Account Unfrozen** - When admin unfreezes account
6. **Password Reset** - When user requests password reset
7. **Contact Form** - When someone submits contact form

### Step 7: SPF and DKIM Setup (Recommended)

#### SPF Record
1. Go to cPanel → Zone Editor
2. Add TXT record:
   - Name: yourdomain.com
   - Value: `v=spf1 a mx ip4:YOUR_SERVER_IP ~all`

#### DKIM
1. Go to cPanel → Email Deliverability
2. Click "Manage" next to your domain
3. Install DKIM keys
4. Verify status is green

### Step 8: Alternative Email Providers

If cPanel email doesn't work, you can use:

#### Gmail SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Courier Savings Bank"
```
Note: Use App Password, not regular password

#### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Courier Savings Bank"
```

#### Mailgun
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=postmaster@yourdomain.com
MAIL_PASSWORD=your-mailgun-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Courier Savings Bank"
```

### Step 9: Email Queue (Optional)

For better performance, use queue for emails:

1. Update .env:
```env
QUEUE_CONNECTION=database
```

2. Add cron job in cPanel:
```bash
* * * * * cd /home/youruser/public_html/banking-app && php artisan queue:work --stop-when-empty
```

This processes email queue every minute.

### Step 10: Monitor Email Delivery

Check these regularly:
- cPanel → Email Deliverability (should be green)
- cPanel → Track Delivery (see sent emails)
- storage/logs/laravel.log (check for errors)
- Test by registering new accounts

---

## Quick Test Checklist

- [ ] Email account created in cPanel
- [ ] .env file updated with correct settings
- [ ] Can login to webmail
- [ ] SPF record added
- [ ] DKIM enabled
- [ ] Test registration sends welcome email
- [ ] Test contact form sends email
- [ ] Emails not going to spam
- [ ] All notification types working

---

## Support Email

The system uses: `support@couriersavingsbank.com`

Make sure to:
1. Create this email account in cPanel
2. Monitor it regularly
3. Set up autoresponder if needed
4. Forward to your main email

---

## Success!

Once emails are working:
- Users receive welcome emails on registration
- All transactions send confirmations
- Admin actions notify users
- System is fully functional!
