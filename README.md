# 🚗 Car Rental Application (Laravel)

## 📌 Description

This project is a car rental web application built with Laravel, designed to simulate a real-world system for managing vehicles, users, and rental workflows.

It includes role-based access control, an admin panel for managing car inventory, and a normalized database structure designed for scalability and maintainability.

The application is currently under active development, with a focus on implementing real-world business logic and best practices.

---

## 🌐 Project Status

🚧 Work in progress – core features implemented, rental system and advanced filtering in development.

## 🚀 Features

### 🔐 Authentication & Authorization

- User registration and login system
- Role-based access (Admin / Customer)
- Middleware protection for routes

### 🧑‍💼 Admin Panel

- Add and view cars
- Manage car attributes through separate tables:
    - Brands
    - Models
    - Colors
    - Fuel types
    - Seats
    - Transmissions
    - Status (available, rented, etc.)

### 🚗 Car Management

- Fully normalized database structure
- Each car is linked to multiple attributes (brand, fuel, etc.)
- Car status system (availability tracking)

### 📄 Customer Document System

- Users can upload identity documents
- Required for rental approval
- Users can delete documents from UI
- Admin retains access for verification (security measure)

---

## 🧠 Key Concepts Implemented

- Role-based authorization using middleware
- Normalized relational database design
- Separation of concerns (MVC architecture)
- Dynamic data relationships (cars linked to multiple attributes)
- File upload handling with access control

---

## 🔍 Features in Progress

### Search & Availability Filtering

- Search form on homepage (UI implemented)
- Planned filtering:
    - By availability
    - By date range (pickup & return)

- System will exclude already reserved cars in selected period

### 💸 Dynamic Pricing & Discounts

- Discounts based on rental duration:
    - Example: 7 days → discount per day
    - Example: 14 days → higher discount per day

- Discounts configurable per car

### 📅 Rental System

- Only available cars can be rented
- Requires document verification (approved or not by admin)
- Full booking flow (in development)

---

## 🧱 Tech Stack

- Laravel
- PHP
- MySQL
- Tailwind CSS
- Blade

---

## ⚙️ Installation

```bash
git clone <your-repo-url>
cd project

composer install
cp .env.example .env
php artisan key:generate

# Configure your database in .env

php artisan migrate
php artisan serve
```

---

## 📸 Screenshots

### Homepage

<img width="2552" height="2492" alt="screenshot-1" src="https://github.com/user-attachments/assets/05fc4c86-0177-44a7-8759-4a0624323a05" />

- Homepage with search functionality for available cars.

---

### Admin Dashboard

<img width="2552" height="1308" alt="screenshot-2" src="https://github.com/user-attachments/assets/a2475793-a826-4c19-bc7c-0cc6aff0e13f" />

- List of cars
- Add car button or table view

---

### Add Car Form

<img width="2552" height="1308" alt="screenshot-3" src="https://github.com/user-attachments/assets/4b02521d-c9d4-484e-8db8-41340f65d6a2" />

- Form fields (brand, fuel, seats, etc.)
- This proves complexity of your system

---

### Database Structure

<img width="2552" height="1308" alt="screenshot-4" src="https://github.com/user-attachments/assets/0c648259-6ae1-4f8c-908c-a2d9c25a596c" />

### 🔗 Database Diagram

You can explore the full database structure here:

## https://dbdiagram.io/d/car-rental-laravel-db-69f23fd5c6a36f9c1bbeaf70

### Document Upload

<img width="2552" height="1308" alt="screenshot-5" src="https://github.com/user-attachments/assets/6679c931-81ba-4d24-a06f-6021e67e1bea" />

- Upload UI for customer documents

---

## 🎯 Goal

The goal of this project is to build a production-like application, focusing on:

- clean architecture
- scalable database design
- real-world business logic
- Laravel best practices

---

## 📌 Status

🟡 In active development
