# Blogging Project Setup

This is a Laravel project designed for managing posts and comments. Follow the instructions below to set up the project on your local machine and start the queue worker to process background jobs.

## Prerequisites

Make sure you have the following installed:

- **PHP** (version 8.1 or higher)
- **Composer** (PHP package manager)
- **MySQL** or **MariaDB** (for the database)

## Setup Instructions

```bash
git clone <repository-url>
cd <project-directory>
composer install
cp .env.example .env
php artisan queue:work
php artisan serve
