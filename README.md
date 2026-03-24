# BankApp - Professional Banking Web Application

A modern, professional banking web application built with Laravel 11 and TailwindCSS, featuring a clean violet-white-black color scheme and global-standard design patterns.

## Features

### User Features
- **Secure Authentication**: Registration and login with Laravel Sanctum
- **Dashboard**: Professional overview with account balance, recent transactions, and quick actions
- **Send Money**: Transfer funds with IRS tax obligation checking
- **Deposit Funds**: Add money to your account
- **Transaction History**: View all transactions with detailed information
- **Responsive Design**: Mobile-first approach with TailwindCSS

### Security Features
- CSRF protection
- Password hashing
- Data validation
- IRS tax alert system integration
- Secure transaction logging

### Design Highlights
- **Color Scheme**: Violet (#7F3FBF) primary, White (#FFFFFF) background, Black (#000000) text
- **Modern UI**: Clean, professional interface inspired by global banking platforms
- **Flat Design**: No gradients, modern flat design principles
- **Typography**: Inter font family for professional look
- **Responsive**: Works seamlessly on desktop and mobile devices

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL

### Setup Steps

1. **Clone the repository**
```bash
cd banking-app
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
Edit `.env` file with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banking_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**
```bash
php artisan migrate:fresh --seed
```

7. **Build assets**
```bash
npm run build
```

8. **Start development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Demo Accounts

After running the seeder, you can use these accounts:

### Regular User (No Tax Issues)
- **Email**: demo@bankapp.com
- **Password**: password
- **Balance**: $5,000.00

### User with Tax Alert
- **Email**: tax@bankapp.com
- **Password**: password
- **Balance**: $3,000.00
- **Note**: This user has pending IRS tax obligations and will see alerts when attempting transfers

### Admin User
- **Email**: admin@bankapp.com
- **Password**: password
- **Balance**: $10,000.00

## Project Structure

```
banking-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   └── TransactionController.php
│   └── Models/
│       ├── User.php
│       ├── Account.php
│       ├── Transaction.php
│       ├── TaxAlert.php
│       └── KycVerification.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   │   └── app.css
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       └── transactions/
├── routes/
│   └── web.php
└── tailwind.config.js
```

## Key Features Implementation

### IRS Tax Alert System
When a user attempts to send money, the system checks for pending tax obligations:
- If tax obligations exist, transaction is blocked
- User receives alert: "You have pending tax obligations with the IRS. Please contact customer support before proceeding with this transaction."
- All checks are performed server-side for security

### Transaction Management
- All transactions are logged with unique reference numbers
- Real-time balance updates
- Transaction history with filtering
- Status tracking (pending, completed, failed)

### Security Best Practices
- Password hashing with bcrypt
- CSRF token protection
- Input validation and sanitization
- SQL injection prevention via Eloquent ORM
- XSS protection

## Development

### Build for development
```bash
npm run dev
```

### Build for production
```bash
npm run build
```

### Run tests
```bash
php artisan test
```

## Railway Deployment

This project can run on Railway as a single Laravel web service (backend + Blade frontend).

- `railway.toml` is included with build and start commands.
- Use `APP_URL=https://couriersavings.up.railway.app`.
- Keep `APP_DEBUG=false` and `APP_ENV=production`.
- Do not hardcode port `80`; Railway provides the runtime port via `$PORT`.

### Demo admin and test users (production DB)

After MySQL is connected, open a shell on the **app** service and run once:

```bash
php artisan demo:install --fresh --force
```

This runs `migrate:fresh --seed` and creates the accounts from `DatabaseSeeder` (admin `admin@bankapp.com` / `password`, plus other demo users — see seeder). **This wipes all existing data** in the database.

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: TailwindCSS 3.x, Blade Templates
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Sanctum
- **Build Tool**: Vite

## Color Palette

- **Primary**: #7F3FBF (Violet)
- **Primary Dark**: #6B35A3
- **Primary Light**: #9B5FD9
- **Background**: #FFFFFF (White)
- **Text**: #000000 (Black)
- **Gray Shades**: For borders and secondary elements

## Future Enhancements

- [ ] 2FA (Two-Factor Authentication)
- [ ] KYC Verification System
- [ ] Bill Payment Module
- [ ] Account Statements (PDF Download)
- [ ] Live Chat Support
- [ ] Admin Panel with Analytics
- [ ] Email Notifications
- [ ] International Transfers
- [ ] Mobile App

## License

This project is open-sourced software licensed under the MIT license.

## Support

For support, email support@bankapp.com or create an issue in the repository.
