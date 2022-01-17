# Introduction

Integrate Vapulus Payment Gateway with your laravel eCommerce store.

It packs in lots of demanding features that allows your business to scale in no time:

- Provide payment directly to the admin account.
- Accept all the cards that Vapulus supports.
- Admin can check the transaction details at admin panel.

## Requirements:

- **Bagisto**: 1.3.2.

## Installation :
- Run the following command
```
composer require bagisto/bagisto-vapulus-payment
```

- Goto config/concord.php file and add following line under 'modules'
```php
\Webkul\Vapulus\Providers\ModuleServiceProvider::class
```

- Run these commands below to complete the setup
```
composer dump-autoload
```

```
php artisan migrate
php artisan route:cache
php artisan config:cache
```

```
php artisan vendor:publish
```
-> Press 0 and then press enter to publish all assets and configurations.

## Configuration
- To signup for the Vapulus merchant account, follow the below URL, You will get the website Id, App Id, SecureHesh, and Password after signup:

```
https://app.vapulus.com/business/signup
```
> That's it, now just execute the project on your specified domain.
