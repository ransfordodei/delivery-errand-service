# Delivery Errand Service - Backend API

This is the Laravel backend API for the Delivery Errand Service platform.

## Database

The application uses SQLite database located at `database/database.sqlite`. All migrations, seeders, and factories are in the `database/` directory.

## Setup Instructions

1. **Install PHP dependencies:**
   ```bash
   composer install
   ```

2. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

3. **Environment Configuration:**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other settings.

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the database with test users:**
   ```bash
   php artisan db:seed
   ```

7. **Start the development server:**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## Test Users

The database seeder creates the following test users:

- **Admin:** admin@example.com / admin1234
- **Customers:**
  - test@example.com / password123
  - john@example.com / john1234
  - jane@example.com / jane1234
- **Vendors:**
  - vendor@example.com / vendor1234
  - pizza@example.com / pizza1234
  - burgers@example.com / burgers1234
- **Riders:**
  - rider@example.com / rider1234
  - tom@example.com / tom1234
  - sarah@example.com / sarah1234

## API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/register` - User registration
- `POST /api/logout` - User logout

### User Management
- `GET /api/user` - Get current user profile

### Orders
- `GET /api/orders` - Get user orders
- `POST /api/orders` - Create new order

## Technologies Used

- **Laravel 11** - PHP Framework
- **MySQL/SQLite** - Database
- **Laravel Sanctum** - API Authentication
- **Composer** - PHP Dependency Management

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
