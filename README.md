# Bobra CPA Connection (back-end)

Integrated:
- SalesDoubler
- DoAffiliate
- LoanGate
- FinLine
- AdmitAd
- Cashka
- PrimeLead
- Leads.SU

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
- add to your web configuration:
```php
<?php

use yii\base\Module;
use Wearesho\Bobra\Cpa\Http\LeadController;

return [
    'modules' => [
        'index' => [
            'class' => Module::class,
            'controllerMap' => [
                'lead' => LeadController::class,
            ],
        ], 
    ],
];
```
- Configure environment variables


## Tests
Run tests:
```bash
./vendor/bin/phpunit
```

## Configuration
This package can be configured using `getenv` function. Available settings:
- **SALES_DOUBLER_ID** - personal id for request to SalesDoubler
- **SALES_DOUBLER_TOKEN** - token for request URI for SalesDoubler
- **DO_AFFILIATE_PATH** - path for DoAffiliate API
(example: *pozichka-ua* in http://tracker2.doaffiliate.net/api/pozichka-ua)
- **LOAN_GATE_GOAL** - (default: 1), goal in URL for LoanGate
- **LOAN_GATE_SECRET** - secure in URL for LoanGate
- **CASHKA_PATH** - unique path in URL for Cashka
- **ADMITAD_POSTBACK_KEY** - postback key for AdmitAd
- **ADMITAD_CAMPAIGN_CODE** - campaign code for AdmitAd
- **PRIME_LEAD_PATH** - secret path in url for PrimeLead
- **LEADS_SU_TOKEN** - token for LeadsSu

If one of key for some CPA network not set 
postback requests for this network will not be done. 


## Add new CPA
To add new CPA network you have to:
- add constant to [UserLead](./src/Records/UserLead.php) with CPA network name
- create form that creates lead in [src/Http/Forms](./src/Http/Forms).
It should use [LeadFormTrait](./src/Http/LeadFormTrait.php)
- add your form to [LeadController](./src/Http/LeadController.php)
- create send service in [src/Services](./src/Services)
It have to implement [ConversionSenderInterface](./src/Interfaces/ConversionSenderInterface.php)
and should extend [AbstractSendService](./src/Services/AbstractSendService.php)
- extend [ConversionSenderFactory](./src/Factories/ConversionSenderFactory.php) with your sender
- add documentation for configuring new CPA network, extend CPA networks list in README

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

## Contributors
- [Alexander <horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
