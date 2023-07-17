
# Laravel Config Builder
I like that we write Laravel configurations in arrays, it's easy to read and understand.
What I don't like is how we read it, we use a `config('key.to.config')` function to fetch the configuration.
The problem with this function is that it won't catch any typo error when you pass it an invalid key string.
Secondly, there is no type hinting, you'll have to add a docblock to indicate what type the configuration is.

To address this, this package will convert any config files into classes. This way we can now access the configurations like objects.
For example: `Database::config()->connections`

## Installation
Install the package via composer:
```bash
composer require princejohnsantillan/laravel-config-builder
```

## Usage
Run `php artisan config:build` 

This will create classes out of your existing config files. Bye default this will be stored in the `App\Config` directory.

You can use these generated config classes to access the configuration. Example: `App::config()->debug`


