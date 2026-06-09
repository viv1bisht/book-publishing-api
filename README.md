# Book Publishing API

## Installation Steps

```bash
git clone https://github.com/viv1bisht/book-publishing-api.git

cd book-publishing-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

## Sample Environment Configuration

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your_secret_key
```

## How To Run Tests

```bash
php artisan test
```

## API Usage Instructions

### Register

POST /api/register

```json
{
    "name":"Vivek",
    "email":"vivek@gmail.com",
    "password":"123456"
}
```

### Login

POST /api/login

Returns JWT Token.

### Create Book

POST /api/books

Authorization: Bearer Token

```json
{
    "title":"Laravel Book",
    "description":"Learning Laravel"
}
```

### Submit Book

POST /api/books/{id}/submit

### Approve Book

POST /api/books/{id}/approve

### Reject Book

POST /api/books/{id}/reject

### Publish Book

POST /api/books/{id}/publish

### Create Chapter

POST /api/chapters

### Create Page

POST /api/pages

### Dashboard

GET /api/dashboard

## Architecture Decisions

* Laravel 12 Framework
* JWT Authentication
* REST API Architecture
* Role Based Access Control
* MySQL Database
* Eloquent ORM
* PHPUnit Testing

## Assumptions Made

* One Author can create multiple Books.
* One Book can have multiple Chapters.
* One Chapter can have multiple Pages.
* Authors submit books.
* Reviewers approve or reject books.
* Admin publishes books.
* Published books become read-only.

## Workflow

Draft → Submitted → Approved → Published

## Test Coverage

* Authentication
* Book Creation
* Workflow Transition
* Moderation Checks
* Authorization Rules
