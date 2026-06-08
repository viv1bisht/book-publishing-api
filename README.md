# Book Publishing API

## Features

- JWT Authentication
- User Registration & Login
- Book Management
- Chapter Management
- Page Management
- Document Upload
- Content Moderation
- Review & Publishing Workflow
- Author Dashboard
- PHPUnit Testing

## Roles

- Author
- Reviewer
- Admin

## Workflow

Draft → Submitted → Approved → Published

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve