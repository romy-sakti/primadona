# Laravel 11 Template With Stisla

[![N|Solid](https://res.cloudinary.com/sistem-informasi/image/upload/c_scale,w_100/v1677141031/logo_srs66z.png)](https://anamapp.my.id)

Free Starter Laravel 11 Template menggunakan [stisla admin dashboard ](https://github.com/stisla/stisla)

Beberapa fitur atau komponen yang ada
[![N|Solid](https://res.cloudinary.com/sistem-informasi/image/upload/v1722952895/moueazjjry5c5qyy1a1m.png)](https://anamapp.my.id)

## Fitur dan komponen

-   Login social media (github, facebook, google, dan twitter) menggunakan library [socialite](https://laravel.com/docs/11.x/socialite)
-   Google captcha
-   Dashboard (widget, log aktivitas terbaru)
-   Profil
    -   Perbarui profil
    -   Perbarui email
    -   Perbarui password
-   Contoh Modul CRUD (Create, Read, Update, Delete) dan Import Excel serta Export (PDF, JSON, Excel)
    -   CRUD
    -   Export
    -   Import
    -   Server side data table
    -   Ajax Method
-   Beberapa contoh menu (tampilan)
-   Log
    -   Log Aktivitas
    -   Laravel Log Viewer
-   User dan role
    -   Manjemen Role dan permission menggunakan [spatie](https://spatie.be/docs/laravel-permission/v6/introduction)
        -   CRUD
        -   Export
        -   Import
    -   Manajemen user
        -   CRUD
        -   Export
        -   Import
        -   Force Login
    -   Manajemen Group Permission
        -   CRUD
        -   Export
        -   Import
    -   Manajemen Permission
        -   CRUD
        -   Export
        -   Import
-   Notifikasi
-   Ubuntu
-   Manajemen file menggunakan [Unisharp](https://unisharp.github.io/laravel-filemanager/)
-   Pengaturan
    -   Umum
    -   Meta
    -   Tampilan
    -   Email
    -   SSO Login dan Register
    -   Lainnya
        -   Google captcha
        -   Setting page
-   Backup database
-   Dropbox
-   Manajemen Menu
    -   Menu (CRUD)
    -   Grup Menu (CRUD)
-   CRUD Generator (menu nya tersembunyi akses via url saja)
-   Server side export file
-   Service dan repository pattern
-   Log Request

## How to install and run

-   `composer install`
-   setup your DB in `.env`
-   `php artisan jwt:secret`
-   `php artisan migrate --seed`
-   `php artisan storage:link`
-   [optional] setup google captcha, google login, facebook login, github login, twitter login in `.env`


