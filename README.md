# Task Manager

**Laravel Version:**  
This project uses Laravel 10.

## Setup

1. Clone this repo.
2. Copy `.env.example` to `.env` and set your DB details.

```php

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

```
3. Run `php artisan migrate`
4. Start server `php artisan serve`

## App Structure & Features

- app/Controller :- all controller file
- app/Model :- User And Task Model
- app/database/migrations :- all the migration files used
- Routes are set up in `routes/web.php`.
- Blade templates for the UI are in `resources/views`.
- logged-in users can manage tasks.
- You can add, edit, delete, and search tasks. Each task has a title, description, due date and status.
- usesd Bootstrap for styling and jQuery for AJAX.