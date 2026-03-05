# Mobile Team - API Consumption Guide

This folder contains everything you need to consume the Delivery Errand Service backend API.

## Files

- `API_DOCUMENTATION.md` - Complete API documentation with endpoints, authentication, and examples
- `api_test.html` - Simple HTML/JavaScript test page to try API calls in browser
- `Delivery_Errand_Service_API.postman_collection.json` - Postman collection for testing API endpoints

## Backend Server

Make sure the backend is running on `http://localhost:8000` before testing.

Start the backend:
```bash
cd ../backend
php artisan serve
```

## Test Users

Use these accounts for testing your mobile app:

### Admin
- Email: `admin@example.com`
- Password: `admin1234`

### Customers
- `test@example.com` / `password123`
- `john@example.com` / `john1234`
- `jane@example.com` / `jane1234`

### Vendors
- `vendor@example.com` / `vendor1234`
- `pizza@example.com` / `pizza1234`
- `burgers@example.com` / `burgers1234`

### Riders
- `rider@example.com` / `rider1234`
- `tom@example.com` / `tom1234`
- `sarah@example.com` / `sarah1234`

## Quick Start

1. **Import Postman Collection**: Import `Delivery_Errand_Service_API.postman_collection.json` into Postman
2. **Test Login**: Use any test user credentials to get an authentication token
3. **Set Token**: Copy the token from login response and set it as `{{token}}` variable in Postman
4. **Test Endpoints**: Try the authenticated endpoints

## API Base URL

For development:
```
http://localhost:8000/api
```

For production (update as needed):
```
https://your-api-domain.com/api
```

## Authentication

All requests except login/register need:
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

## Need Help?

- Check `API_DOCUMENTATION.md` for detailed endpoint information
- Use `api_test.html` to test API calls directly in browser
- Contact the backend team if you encounter API issues