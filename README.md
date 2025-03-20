<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This is a web-based conference management system built using Laravel. The system provides user authentication, role-based access control, and CRUD functionalities for managing invoices, LoAs, receipts, virtual accounts, and bank transfers.

## Features

- **User Authentication** (Login, Register, Update, Delete)
- **Role-Based Access Control**
  - Super Admin: Full access to all features
  - Admin ICoDSA & Admin ICICTYA: Can only manage LoA, Invoices, and Receipts
- **CRUD Operations**
  - Virtual Accounts
  - Bank Transfers
  - LoA (Letter of Acceptance)
  - Invoices
  - Receipts

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repository.git
   cd your-repository
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Set up environment variables:
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate --seed
   ```
6. Serve the application:
   ```bash
   php artisan serve
   ```

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login and receive a token
- `POST /api/logout` - Logout from the system

### User Management
- `GET /api/users` - Get all users (Super Admin only)
- `PUT /api/users/{id}` - Update user information
- `DELETE /api/users/{id}` - Delete a user

### LoA (Letter of Acceptance)
- `GET /api/loas` - Retrieve all LoAs
- `POST /api/loas` - Create a new LoA
- `PUT /api/loas/{id}` - Update an LoA
- `DELETE /api/loas/{id}` - Delete an LoA

### Invoices
- `GET /api/invoices` - Retrieve all invoices
- `POST /api/invoices` - Create a new invoice
- `PUT /api/invoices/{id}` - Update an invoice
- `DELETE /api/invoices/{id}` - Delete an invoice

### Receipts
- `GET /api/receipts` - Retrieve all receipts
- `POST /api/receipts` - Create a new receipt
- `PUT /api/receipts/{id}` - Update a receipt
- `DELETE /api/receipts/{id}` - Delete a receipt

### Virtual Accounts & Bank Transfers
- `GET /api/virtual-accounts` - Retrieve all virtual accounts
- `POST /api/virtual-accounts` - Create a new virtual account
- `PUT /api/virtual-accounts/{id}` - Update a virtual account
- `DELETE /api/virtual-accounts/{id}` - Delete a virtual account
- `GET /api/bank-transfers` - Retrieve all bank transfers
- `POST /api/bank-transfers` - Create a new bank transfer
- `PUT /api/bank-transfers/{id}` - Update a bank transfer
- `DELETE /api/bank-transfers/{id}` - Delete a bank transfer

## Contributing


## Security


## License


