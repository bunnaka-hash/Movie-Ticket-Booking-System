# 🎬 Movie Ticket Booking System

A web-based Movie Ticket Booking System developed using **Laravel 10**. This project allows customers to browse movies, book tickets, and manage their bookings while providing administrators and staff with tools to manage movies, cinemas, showtimes, and ticket verification.

This project was developed as the final project for a Laravel short course to demonstrate the use of Laravel's MVC architecture, authentication, middleware, RESTful APIs, database relationships, and CRUD operations.

---

## 📌 Project Objectives

- Build a complete web application using Laravel 10.
- Implement role-based authentication and authorization.
- Practice RESTful API development.
- Apply Laravel best practices using MVC architecture.
- Demonstrate database relationships and CRUD operations.

---

# 🚀 Features

## 👤 Customer

- Register an account
- Login / Logout
- Browse available movies
- Search movies
- View movie details
- Book movie tickets
- Cancel bookings
- View booking history
- Update profile

---

## 👨‍💼 Admin

- Dashboard
- Manage Movies
- Manage Cinemas
- Manage Halls
- Manage Showtimes
- Manage Users
- View booking reports

---

## 🎫 Staff

- View today's bookings
- Verify customer tickets
- Check customers into the cinema

---

# 🛠 Technologies

- Laravel 10
- PHP 8.x
- MySQL
- Blade Template Engine
- Bootstrap / Tailwind CSS
- JavaScript
- REST API
- Laravel Breeze Authentication

---

# 🏗 System Architecture

Laravel follows the MVC (Model-View-Controller) architecture.

```
Client
   │
   ▼
Routes
   │
   ▼
Controller
   │
   ▼
Model
   │
   ▼
Database
   │
   ▼
Blade View
```

---

# 👥 User Roles

| Role | Permissions |
|------|-------------|
| Admin | Full system management |
| Customer | Book movie tickets |
| Staff | Verify tickets and check customers in |

---

# 📂 Database Tables

- users
- roles
- movies
- cinemas
- halls
- seats
- showtimes
- bookings
- booking_details

---

# 🔗 Database Relationships

```
Movie
 └── hasMany Showtimes

Cinema
 └── hasMany Halls

Hall
 └── hasMany Seats

Hall
 └── hasMany Showtimes

User
 └── hasMany Bookings

Booking
 └── belongsTo User

Booking
 └── belongsTo Showtime

Booking
 └── hasMany BookingDetails

Seat
 └── belongsTo Hall
```

---

# 🔐 Authentication

- Login
- Register
- Logout
- Password Hashing
- Role-Based Authentication

---

# 🛡 Middleware

- auth
- guest
- admin
- customer
- staff

Middleware protects routes according to user roles.

---

# 📡 REST API

## Movies

| Method | Endpoint | Description |
|---------|----------|-------------|
| GET | /api/movies | Get all movies |
| GET | /api/movies/{id} | Get movie details |

---

## Showtimes

| Method | Endpoint | Description |
|---------|----------|-------------|
| GET | /api/showtimes | Get available showtimes |

---

## Bookings

| Method | Endpoint | Description |
|---------|----------|-------------|
| POST | /api/bookings | Create booking |
| PUT | /api/bookings/{id} | Update booking |
| DELETE | /api/bookings/{id} | Cancel booking |

---

## Profile

| Method | Endpoint | Description |
|---------|----------|-------------|
| GET | /api/profile | Get user profile |

---

# 📋 Validation

Laravel validation is used throughout the application to ensure data integrity.

Examples:

- Required fields
- Email validation
- Password confirmation
- Seat availability
- Showtime validation

---

# 📷 File Upload

Administrators can upload movie posters when creating or editing movies.

---

# 🔍 Search

Customers can search movies by:

- Movie title
- Genre
- Release date

---

# 📄 Pagination

Pagination is implemented for:

- Movies
- Users
- Bookings

---

# 📁 Project Structure

```
app
 ├── Http
 │    ├── Controllers
 │    ├── Middleware
 │    └── Requests
 │
 ├── Models
 │
 ├── Providers
 │
database
 ├── migrations
 ├── seeders
 └── factories

routes
 ├── web.php
 └── api.php

resources
 ├── views
 └── css

public
storage
```

---

# ▶ Installation

Clone the repository

```bash
git clone https://github.com/bunnaka-hash/Movie-Ticket-Booking-System.git
```

Go to the project

```bash
cd movie-ticket-booking
```

Install dependencies

```bash
composer install
```

Install frontend dependencies

```bash
npm install
```

Copy environment file

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Configure the database in the `.env` file.

Run migrations

```bash
php artisan migrate
```

(Optional) Seed the database

```bash
php artisan db:seed
```

Run the development server

```bash
php artisan serve
```

Compile frontend assets

```bash
npm run dev
```

---

# 📸 Screenshots

- Login
- Dashboard
- Movie List
- Movie Details
- Seat Selection
- Booking History

---

# 📈 Future Improvements

The following features are planned for future versions:

- Online payment integration
- QR code tickets
- Email notifications
- Movie reviews and ratings
- Favorite movies
- Revenue dashboard
- Promo codes
- Real-time seat availability

---

# 👨‍💻 Author

**Pen Bunnaka**

Institute of Technology of Cambodia (ITC)

Department of Information and Communication Engineering (GIC)

---

# 📄 License

This project was created for educational purposes as part of a Laravel 10 short course.
