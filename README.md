# Laravel 12 + Vue 3 Full-Stack Application

A full-stack application using:

-   Laravel 12.14.1
-   PHP 8.3.10
-   Node.js v22.6.0
-   Vue 3 (with Tailwind CSS)
-   JWT Authentication

---

## 🚀 Getting Started

### 1. Clone the Repository

git clone https://github.com/dtrxx14/dev-exam.git
cd dev-exam

### 2. Install Backend Dependencies

composer install

### 3. Copy and Configure .env

cp .env.example .env

Open .env and configure your database and app details:
APP_NAME=LaravelApp
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dev_exam
DB_USERNAME=root
DB_PASSWORD=

### 4. Generate App Key and JWT Secret

php artisan key:generate
php artisan jwt:secret

### 5. Run Database Migrations

php artisan migrate

### 6. Start the Development Server

php artisan serve

Default server URL: http://127.0.0.1:8000

## Optional (Running Tests)

php artisan test
