# Delivery Errand Service

A comprehensive delivery and errand service platform with separate backend API and mobile applications.

## Project Structure

```
delivery-errand-service/
├── backend/           # Laravel API Backend
│   ├── database/      # Database files, migrations, seeders
│   │   └── database.sqlite  # SQLite database file
│   └── ...           # Other Laravel files
├── mobile/           # API documentation and testing tools
├── database/         # Legacy folder (can be deleted after confirming backend works)
├── README.md         # This file
└── .git/            # Git repository
```

**Note:** There are two `database/` folders due to the project reorganization. The correct database files are now in `backend/database/`. The root `database/` folder contains a duplicate SQLite file and can be safely deleted once you've confirmed the backend is working properly.

## Backend (Laravel API)

The backend is a Laravel application that provides REST API endpoints for the mobile application.

### Setup Instructions

1. **Navigate to backend directory:**
   ```bash
   cd backend
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Environment Configuration:**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials and other settings.

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

7. **Seed the database with test users:**
   ```bash
   php artisan db:seed
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

### Test Users Created

The seeder creates the following test users:

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

## Mobile App (API Consumption)

The mobile folder contains API documentation and testing tools for the mobile development team:

- **API Documentation** (`mobile/API_DOCUMENTATION.md`) - Complete endpoint reference
- **Postman Collection** (`mobile/Delivery_Errand_Service_API.postman_collection.json`) - Import into Postman for testing
- **HTML Test Page** (`mobile/api_test.html`) - Test API calls directly in browser
- **Test Users** - Pre-seeded accounts for testing different user roles

The mobile team can consume the backend API without needing to set up any mobile development framework.

### Authentication
- `POST /api/login` - User login
- `POST /api/register` - User registration
- `POST /api/logout` - User logout

### User Management
- `GET /api/user` - Get current user profile
- `PUT /api/user` - Update user profile

### Orders
- `GET /api/orders` - Get user orders
- `POST /api/orders` - Create new order
- `GET /api/orders/{id}` - Get specific order
- `PUT /api/orders/{id}` - Update order status

### Vendors
- `GET /api/vendors` - Get all vendors
- `GET /api/vendors/{id}` - Get vendor details
- `GET /api/vendors/{id}/menu` - Get vendor menu

## Development Workflow

1. **Backend Development:**
   - Make changes in `backend/` directory
   - Test API endpoints using Postman or similar tools
   - Run `php artisan test` for unit tests

2. **Mobile Development:**
   - Make changes in `mobile/` directory
   - Test on emulator/simulator
   - Use React Native Debugger for debugging

3. **Version Control:**
   - Both backend and mobile code are in the same repository
   - Use feature branches for new features
   - Keep backend and mobile changes separate when possible

## Technologies Used

### Backend
- **Laravel 11** - PHP Framework
- **MySQL/SQLite** - Database
- **Sanctum** - API Authentication
- **Composer** - PHP Dependency Management

### Mobile (API Consumption)
- **REST API** - JSON-based API endpoints
- **Bearer Token Authentication** - JWT-style authentication
- **Postman** - API testing and documentation
- **HTML/JavaScript** - Simple testing interface

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License.