## Learning Laravel Passport

- Install fresh laravel project.
    - Create Database and config env file.
 
## Authentication
Laravel's laravel/jetstream package provides a quick way to scaffold all of the routes, views, and other backend logic needed for authentication using a few simple commands:  

```composer require laravel/jetstream```  

```php artisan jetstream:install livewire```  

```php artisan migrate```

## Installation Passport

To get started, install Passport via the Composer package manager:  

```composer require laravel/passport```

The Passport service provider registers its own database migration directory with the framework, so you should migrate your database after installing the package. The Passport migrations will create the tables your application needs to store clients and access tokens:  

```php artisan migrate:fresh```

Next, you should run the `passport:install` command. This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens:  

```php artisan passport:install```  

After running the `passport:install` command, add the `Laravel\Passport\HasApiTokens` trait to your `App\Models\User` model. This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes:  

```
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```

Next, you should call the `Passport::routes` method within the `boot` method of your `AuthServiceProvider`. This method will register the routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens:

```
use Laravel\Passport\Passport;

public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
```

Finally, in your `config/auth.php` configuration file, you should set the driver option of the `api` authentication guard to `passport`. This will instruct your application to use Passport's `TokenGuard` when authenticating incoming API requests:
