# Delivery Errand Service - API Documentation

This document provides everything the mobile development team needs to consume the backend API.

## Base URL
```
http://localhost:8000/api
```

## Authentication

All API requests (except login/register) require authentication using Bearer tokens.

### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com",
    "role": "user"
  },
  "token": "1|abc123def456..."
}
```

### Register
```http
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "user"
}
```

## Test Users

Use these accounts for testing:

### Admin
- Email: `admin@example.com`
- Password: `admin1234`
- Role: admin

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

## API Endpoints

### User Profile
```http
GET /api/user
Authorization: Bearer {token}
```

### Orders
```http
GET /api/orders
Authorization: Bearer {token}
```

### Create Order
```http
POST /api/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "vendor_id": 1,
  "items": [
    {
      "name": "Pizza Margherita",
      "quantity": 2,
      "price": 15.99
    }
  ],
  "delivery_address": "123 Main St",
  "total_amount": 31.98
}
```

### Vendors
```http
GET /api/vendors
Authorization: Bearer {token}
```

### Update Order Status (Vendor/Rider)
```http
PUT /api/orders/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "confirmed"
}
```

## Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

## Error Response Format
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

## Rate Limiting

- 60 requests per minute for authenticated users
- 10 requests per minute for unauthenticated users

## Headers Required

For authenticated requests:
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
Accept: application/json
```