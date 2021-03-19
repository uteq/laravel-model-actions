# Magically adds actions to a model

[![Latest Version on Packagist](https://img.shields.io/packagist/v/uteq/laravel-model-actions.svg?style=flat-square)](https://packagist.org/packages/uteq/laravel-model-actions)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/uteq/laravel-model-actions/run-tests?label=tests)](https://github.com/uteq/laravel-model-actions/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/uteq/laravel-model-actions/Check%20&%20fix%20styling?label=code%20style)](https://github.com/uteq/laravel-model-actions/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/uteq/laravel-model-actions.svg?style=flat-square)](https://packagist.org/packages/uteq/laravel-model-actions)


This package will magically add actions to a model. Simply adding the WithActions trait:


You can also use a static method
```php
use App\Models\User;
use App\Actions\User\Create;

User::do(Create::class, $input);
```

And a concrete method
```php
use App\Actions\User\Update;

$user->action()->update($input);
$user->action('update', $input);
$user->action(Update::class, $input);
```

This package was inspired by this read about OOP: https://www.tonysm.com/when-objects-are-not-enough/#objects-in-the-large
Especially the last part about actions being added to a model made sense to me.
This will keep your models clean, and your actions separated.

The idea behind this package is that adding actions makes your application more scalable.
'Grouping' these actions by adding them to a model, makes it easier to comprehend where the action is for. It is more declarative having your model $user->action() perform an action than having the action out of the blue. To create more context you would have to always prefix your action UserCreateAction for example. 

Not convinced about using Actions in your application? Read this excellent blog post of Brent from Spatie.be  https://stitcher.io/blog/laravel-beyond-crud-03-actions

You will need php 8.0

## Installation

You can install the package via composer:

```bash
composer require uteq/laravel-model-actions
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Uteq\ModelActions\ModelActionsServiceProvider" --tag="laravel-model-actions-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * You can overwrite the method used to handle the
     * action. By default this is __invoke.
     */
    'method' => '__invoke',    
];
```
## Usage

### On your model
Add the WithActions trait to the model
```php
use Uteq\ModelActions\Concerns\WithActions;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use WithActions;
}
```

### Directory

The actions should be added in the following folder structure

```
App
├── Actions
│   └── User
│       ├── Create.php 
│       ├── Update.php 
│       ├── Destroy.php
│       └── AddImage.php
└── Models
    └── User.php
```



After that you can always access the actions from your model:

This is how an action class looks like:

```php
class Update
{
    public function __invoke(User $model, array $input = [])
    {
        // Now add you own logic here
    }
}
```
As you can see the $user will automatically be injected into the __invoke method. The system knows the user because you are calling in from the user. Please note that the model is always the first parameter.

The name of the Action class will be used as the method name.
So a class UpdateImage will be accessible using User::action()->updateImage($input); 

```php
$user->action(Update::class, $input);
```

### Dependency injection in Actions
Dependency injection in the __construct of the action is by default.
So you can do this:

```php
class Destroy
{
    public function __construct(
        protected PublicDestroyer $destroyer,
    ) { }
    
    public __invoke(User $user, array $input = [])
    {
        ($this->destroyer)($user, $input);
    }
}
```

### Parameter binding
Parameter binding for model actions is pretty straight forward. We have Named parameters (see below) and simply using the given order:

```php
class Action
{
    public function __invoke($var1, $var2)
    {
    
    }
}
```

```php
User::do(Action::class, 'var1', 'var2');
```

### Named parameters
Utilizing php 8's named paramters you are able to be very strict into what your action class accepts.

```php
class Action
{
    public function __invoke($name)
    {
    
    }
}
```


```php
User::do(Action::class, name: 'test');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nathan Jansen](https://github.com/nathanjansen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
