
## About
This project is a simple realtime worker scheduler app with [Laravel 8](https://github.com/laravel/laravel) + [Vue js](https://github.com/vuejs/vue) + [Inertia js](https://github.com/inertiajs) + [websockets](https://github.com/beyondcode/laravel-websockets).


## Setup
Do the following steps one by one:

- clone project on your destination folder
- create mysql database and add update its information in .env file.
- open terminal in project folder and run following commands :
- composer install
- php artisan easy:install

## Usage
For running the project you should first start the websocket server by following command:
`php artisan websockets:serve`

then you can login with admin or worker account with these credentials:

---
admin email: admin@email.com

admin password: password

---

worker email: worker@email.com

worker password: password
