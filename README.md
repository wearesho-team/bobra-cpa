# Bobra CPA Connection (back-end)


## Installation

### As dependency
- install using composer
```bash
composer require wearesho-team/bobra-cpa
```
- add to your `bootstrap.php`:
```php
<?php
// bootstrap.php

Yii::setAlias(
    '@Wearesho\Bobra\Cpa\Migrations', // your namespace here
    "path-to-vendor/wearesho-team/bobra-cpa/migrations" // path to package migrations folder
);
```
- add to your console `config.php`:
```php
<?php
// console/config.php

use yii\console\controllers\MigrateController;

return [
    // some code
    
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationNamespaces' => [
                'Wearesho\\Bobra\\Cpa\\Migrations',          
            ],
        ],
    ],    
];
```

## Tests
Run tests:
```bash
./vendor/bin/phpunit
```

## Configuration
This package can be configured using `getenv` function. Available settings:
- SALES_DOUBLER_TOKEN - token for request URI for SalesDoubler

If one of key for some CPA network will not be preset 
postback requests for this network will not be done. 


## Structure

```
migrations/     contains namespaced migrations (using Yii2 namespace autoloader)
src/            contains all source files (using composer autoloader)
tests/
    Mocks/          contains mocks for tests
    Fixtures/       contains Yii2 fixtures
    Unit/           contains PHPUnit tests 
vendor/                  contains dependent 3rd-party packages
```
## License
[MIT](./LICENSE)