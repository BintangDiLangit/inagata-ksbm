# API KSBM

this repository provide API to KSBM application, the entire application is made by using laravel 8

## Requirements

-   composer 2.x
-   laravel 8
-   php >= 7.4

## Installation

-   first clone this repo

```bash
$ git clone https://gitlab.com/technosmith/ksbm.git
```

-   go into the project directory

```bash
$ cd ksbm
```

-   then install the laravel

```bash
$ composer install
```

-   after that copy the `.env.example` file and update it using your database credentials

```bash
$ cp .env.example .env
```

-   do artisan migrate

```bash
$ php artisan migrate --seed
```

-   lastly serve your server

```bash
$ php artisan serve
```

## API Documentation

-   https://documenter.getpostman.com/view/14661735/UV5WEJTK

## DB

-   https://dbdocs.io/bintangmfhd/KSBM
