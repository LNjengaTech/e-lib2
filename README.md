# 📚 Laravel 12 Library Management System

A full-featured **Library Management System** built using **Laravel 12**, designed to handle book cataloging, user management, borrowing, and return operations. Ideal for academic institutions, public libraries, or personal book collections.

## 🚀 Features

- User registration and authentication
- Admin and regular user roles
- Book catalog with categories and authors
- Borrowing and return system
- Overdue loan detection and fines
- Responsive admin dashboard
- Reservation system
- Daily/weekly scheduled tasks (via Laravel Scheduler)

## 🛠️ Tech Stack

- Laravel 12 (PHP framework)
- MySQL (Database)
- Blade (Templating engine)
- Tailwind CSS (Styling)
- Laravel Breeze (Authentication scaffolding)
- Artisan Console (Command scheduling)

---

## 🔧 Setup Instructions

Follow these steps to run the project on your local machine:

### 1. Clone the Repository

git clone https://github.com/your-username/library-management-system.git
cd library-management-system

### 2.  Install Dependencies

composer install
npm install

### 3.  Set Up Environment File
cp .env.example .env

### 4.  Create your own DB and Update these variables in .env:
APP_NAME="Library Management System"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password


### 5.  Generate App Key
php artisan key:generate

### 6.  Run Migrations and Seeders
php artisan migrate --seed

### 7.  Compile Frontend Assets
npm run dev

### 8.  Start the Development Server
php artisan serve

### 9.  Default Admin and SuperAdmin Login
Check AdminUserSeeder.php in /database/seeders






### 10. Scheduled Commands
This project uses Laravel Scheduler for background tasks (checking overdue loans). 

In development: In the terminal, run:
php artisan schedule:run

In production: Set up a CRON job on your server to run:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1


### 11.  🧑‍💻 Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you'd like to change.

#### 12.  go
This project is open-sourced under the MIT License.


