# Book Publishing API

Repository:
https://github.com/viv1bisht/book-publishing-api

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

# API Documentation

## Authentication

### Register User

**POST** `/api/register`

Request:

```json
{
    "name":"Vivek",
    "email":"vivek@gmail.com",
    "password":"123456"
}
```

Response:

```json
{
    "status": true,
    "message": "User registered successfully"
}
```

---

### Login User

**POST** `/api/login`

Request:

```json
{
    "email":"vivek@gmail.com",
    "password":"123456"
}
```

Response:

```json
{
    "status": true,
    "token": "JWT_TOKEN"
}
```

---

## Books

### Get Books

**GET** `/api/books`

Header:

```text
Authorization: Bearer TOKEN
```

---

### Create Book

**POST** `/api/books`

Request:

```json
{
    "title":"Laravel Mastery",
    "description":"Complete Laravel Guide"
}
```

---

### Update Book

**PUT** `/api/books/{id}`

Request:

```json
{
    "title":"Updated Title",
    "description":"Updated Description"
}
```

---

### Delete Book

**DELETE** `/api/books/{id}`

---

## Workflow

### Submit Book

**POST** `/api/books/{id}/submit`

---

### Approve Book

**POST** `/api/books/{id}/approve`

Reviewer Only

---

### Reject Book

**POST** `/api/books/{id}/reject`

Reviewer Only

---

### Publish Book

**POST** `/api/books/{id}/publish`

Admin Only

---

## Chapters

### Create Chapter

**POST** `/api/chapters`

Request:

```json
{
    "book_id": 1,
    "title": "Introduction",
    "description": "Chapter One"
}
```

---

### Get Book Chapters

**GET** `/api/books/{id}/chapters`

---

## Pages

### Create Page

**POST** `/api/pages`

Request:

```json
{
    "chapter_id": 1,
    "title": "Page 1",
    "content": "Welcome to Laravel"
}
```

---

### Get Chapter Pages

**GET** `/api/chapters/{id}/pages`

---

## Dashboard

### Author Dashboard

**GET** `/api/dashboard`

Response:

```json
{
    "total_books": 5,
    "draft_books": 2,
    "approved_books": 2,
    "published_books": 1
}
```

---

## Document Upload

### Upload File

**POST** `/api/books/{id}/upload`

Form Data:

```text
file : document.docx
```

Supported Formats:

* doc
* docx
* pdf
* jpg
* jpeg
* png


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

Draft → Submitted → Under Review → Approved → Published

## Test Coverage

* Authentication
* Book Creation
* Workflow Transition
* Moderation Checks
* Authorization Rules
