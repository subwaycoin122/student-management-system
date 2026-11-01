# 🎓 Student Management System (SMS) - Laravel 13

A modern, responsive, and robust **Student Management System** developed with **Laravel 13**, featuring relational database architecture, authentication, full CRUD operations with multi-criteria filtering & searching, automated seeding, and comprehensive feature test coverage.

---

## 📌 Project Overview

This project satisfies all requirements for the **Final Project**:
1. **Authentication System**: Secure user registration, login, and session-managed logout.
2. **Relational Database & Migrations**: Full foreign key relationships between `departments` (PK: `dept_id`) and `students` (FK: `dept_id`, PK: `student_id`).
3. **Model Relationships**: Connected Eloquent models with `hasMany` and `belongsTo` inverse relationships.
4. **CRUD with Filter & Search**: Search students by name or enrollment code; filter students by department (`dept_name`) and gender.
5. **Database Seeding**: Automated seeding for realistic departments, students, and administrative users.
6. **Form Templates**: Submission forms for students featuring interactive selection of `Dept_Name` from the `departments` table.
7. **HTML Tables**: Responsive tabular display with action buttons (View, Edit, Delete), status badges, and Bootstrap 5 pagination.

---

## 🗄️ Relational Database Schema

### A. `departments` Table
| Column Name | Type | Key | Description |
|---|---|---|---|
| `dept_id` | `unsignedBigInteger` | **PK** | Primary key (Auto Increment) |
| `dept_name` | `varchar(255)` | - | Department name (e.g. Computer Science) |
| `manager_id` | `varchar(100)` | - | Head of Department / Manager identifier |
| `location_id` | `varchar(100)` | - | Campus building or room code |
| `created_at` | `timestamp` | - | Record creation timestamp |
| `updated_at` | `timestamp` | - | Record last updated timestamp |

### B. `students` Table
| Column Name | Type | Key | Description |
|---|---|---|---|
| `student_id` | `unsignedBigInteger` | **PK** | Primary key (Auto Increment) |
| `student_name` | `varchar(255)` | - | Full name of student |
| `gender` | `varchar(20)` | - | Gender (`Male`, `Female`, `Other`) |
| `dob` | `date` | - | Date of birth |
| `enrollment` | `varchar(50)` | **Unique** | Unique enrollment / matriculation code |
| `enrollment_date` | `date` | - | Official enrollment date |
| `description` | `text` | - | Notes, achievements, or remarks (nullable) |
| `dept_id` | `unsignedBigInteger` | **FK** | Foreign key referencing `departments(dept_id)` |
| `created_at` | `timestamp` | - | Record creation timestamp |
| `updated_at` | `timestamp` | - | Record last updated timestamp |

---

## 🚀 Quick Start Guide

### 1. Requirements
- **PHP** >= 8.3
- **Composer** >= 2.x
- **SQLite** or **MySQL** (Default uses zero-config SQLite)

### 2. Setup & Installation
```bash
# Clone the repository
git clone https://github.com/Seammorodoksatya/student-management-system.git
cd student-management-system

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seed sample departments & students
php artisan migrate:fresh --seed
```

### 3. Start Development Server
```bash
php artisan serve
```
Open your browser at: **`http://127.0.0.1:8000`**

---

## 🔑 Demo Login Credentials

The seeder automatically generates the following user credentials:

| Role | Email | Password |
|---|---|---|
| **System Administrator** | `admin@example.com` | `password123` |
| **Academic Officer** | `officer@example.com` | `password123` |

You can also use the **Register** form at `/register` to create a new personal account.

---

## 🧪 Automated Testing

All features are covered by automated tests using PHPUnit.

```bash
php artisan test
```

**Test Coverage Highlights:**
- `test_guest_is_redirected_to_login`: Verifies route security for guests.
- `test_user_can_login_and_logout`: Tests session creation and termination.
- `test_user_can_register`: Verifies user registration flow.
- `test_department_crud_operations`: Verifies Insert, Read, Search, Update, and Delete on departments.
- `test_student_crud_operations`: Verifies Insert (linked to department), Search by Name, Filter by Department, Filter by Gender, Update, and Delete on students.

---

## 📤 Pushing to GitHub

To push this repository to your GitHub account (`Seammorodoksatya`):

```bash
# 1. Create a new empty repository on https://github.com/new named "student-management-system"
# 2. Add your GitHub remote:
git remote add origin https://github.com/Seammorodoksatya/student-management-system.git

# 3. Rename branch to main (if desired) and push:
git branch -M main
git push -u origin main
```
