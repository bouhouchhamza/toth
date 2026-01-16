# Thoth Learning Management System

A clean, secure PHP backend foundation for a Learning Management System built with native PHP following MVC architecture.

## Architecture

### MVC Pattern
- **Models**: Handle database operations and business logic
- **Views**: Display HTML templates with escaped PHP variables
- **Controllers**: Coordinate requests between models and views

### Project Structure
```
thoth/
├── public/
│   ├── index.php          # Single entry point
│   └── .htaccess          # URL rewriting and security
├── app/
│   ├── core/
│   │   ├── Router.php     # Central routing system
│   │   ├── Controller.php # Base controller class
│   │   ├── Database.php   # PDO database connection
│   │   └── Auth.php       # Authentication & security
│   ├── controllers/
│   │   └── StudentController.php
│   ├── models/
│   │   ├── Student.php
│   │   ├── Course.php
│   │   └── Enrollment.php
│   └── views/
│       └── student/
│           ├── login.php
│           ├── register.php
│           ├── dashboard.php
│           ├── course.php
│           └── 404.php
├── config/
│   └── database.php       # Database configuration
└── database.sql           # Database schema
```

## Routing System

The application uses a centralized routing system defined in `public/index.php`:

### Public Routes
- `/` → Home page (redirects to login)
- `/login` → Login form and processing
- `/register` → Registration form and processing

### Protected Routes (Authentication Required)
- `/student/dashboard` → Student dashboard
- `/student/course/{id}` → Course details page
- `/student/enroll` → Course enrollment (POST)
- `/logout` → Logout and session destruction

### How Routing Works
1. All requests go through `public/index.php` (single entry point)
2. Router class matches URL patterns to controller methods
3. Protected routes automatically check authentication
4. Parameters in URLs (like `{id}`) are passed to controller methods

## Authentication System

### Features
- **Registration**: Students can register with name, email, and password
- **Login**: Email and password authentication
- **Sessions**: PHP sessions maintain login state
- **Password Security**: Uses `password_hash()` and `password_verify()`
- **CSRF Protection**: Tokens prevent cross-site request forgery
- **XSS Protection**: All output is escaped with `htmlspecialchars()`

### Authentication Flow
1. User submits login form
2. Controller validates credentials using Student model
3. If valid, `Auth::login()` creates session
4. Protected routes use `Auth::requireAuth()` to check login
5. `Auth::logout()` destroys session on logout

## Database

### Schema
- **students**: id, name, email, password, timestamps
- **courses**: id, title, description, timestamps
- **enrollments**: id, student_id, course_id, enrollment_date

### Setup
1. Import `database.sql` into MySQL
2. Update database credentials in `config/database.php`
3. Ensure PDO MySQL extension is enabled

## Security Features

- **SQL Injection Prevention**: All queries use PDO prepared statements
- **XSS Prevention**: All user output is escaped
- **CSRF Protection**: Forms include CSRF tokens
- **Password Hashing**: Modern PHP password hashing
- **Session Security**: Proper session management
- **Access Control**: Protected routes require authentication
- **Input Validation**: Email format and required field validation

## Installation

1. Clone or copy the project to your web server
2. Create MySQL database and import `database.sql`
3. Configure database credentials in `config/database.php`
4. Ensure `public/` is web root (or configure virtual host)
5. Enable `mod_rewrite` for Apache servers
6. Ensure PHP PDO MySQL extension is enabled

## Usage

1. Navigate to the application URL
2. Register a new student account
3. Login to access the dashboard
4. Browse and enroll in courses
5. View course details and progress

## Sample Data

The SQL script includes:
- 4 sample courses
- 3 sample students (password: `password123`)

## Extension Points

The system is designed to be easily extensible:
- Add new controllers for additional features
- Create new models for additional entities
- Add new views with consistent styling
- Extend routing for new endpoints
- Add middleware for additional security layers
