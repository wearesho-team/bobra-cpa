# Bobra CPA Integrations
[![Build Status](https://travis-ci.org/wearesho-team/bobra-cpa.svg?branch=master)](https://travis-ci.org/wearesho-team/bobra-cpa)
[![codecov](https://codecov.io/gh/wearesho-team/bobra-cpa/branch/master/graph/badge.svg)](https://codecov.io/gh/wearesho-team/bobra-cpa)

[Change Log](./CHANGELOG.md)

## Integrated
- [SalesDoubler](./src/SalesDoubler)
- [DoAffiliate](./src/DoAffiliate)
- [LoanGate](./src/LoanGate)
- [FinLine](./src/FinLine)
- [AdmitAd](./src/AdmitAd)
- [Cashka](./src/Cashka)
- [PrimeLead](./src/PrimeLead)
- [Leads.SU](./src/LeadsSu)
- [Letmeads](./src/Letmeads)
- [LinkProfit](./src/LinkProfit)

## Requirements
- MySQL ^5.7 or PostgreSQL ^9.4
- PHP ^7.2

## Usage
### Installation
- install using composer
```bash
composer require wearesho-team/bobra-cpa
```

### Configuration
- Append [Bootstrap](./src/Bootstrap.php) to your applications bootstraps.  
*Note: if you have queue configured before this bootstrap
[Conversion\Queue\Service](./src/Conversion/Queue/Service.php) will be used*
- Add [Web\Controller](./src/Web/Controller.php) to your application web controller map
(if you want to create leads)
- Use [Conversion\ServiceInterface](./src/ConversionInterface.php) from container
to register conversions:
```php
<?php

use Wearesho\Bobra\Cpa;

$lead = Cpa\Lead::find()
    ->andWhere(['=', 'user_id', \Yii::$app->user->id])
    ->andWhere(['=', 'product', 'current_product_code'])
    ->one();

if($lead instanceof Cpa\Lead) {
    return;
}

/** @var Cpa\Conversion\ServiceInterface $service */
$service = \Yii::$container->get(Cpa\Conversion\ServiceInterface::class);
$service->register($lead, 'conversionId');
```

### Environment
This package can be configured by environment variables out-of-box:

- **SALES_DOUBLER_ID** - personal id for request to SalesDoubler
- **SALES_DOUBLER_TOKEN** - token for request URI for SalesDoubler
- **DO_AFFILIATE_PATH** - path for DoAffiliate API
(example: *pozichka-ua* in http://tracker2.doaffiliate.net/api/pozichka-ua)
- **LOAN_GATE_GOAL** - (default: 1), goal in URL for LoanGate
- **LOAN_GATE_SECRET** - secure in URL for LoanGate
- **CASHKA_PATH** - unique path in URL for Cashka
- **ADMITAD_POSTBACK_KEY** - postback key for AdmitAd
- **ADMITAD_CAMPAIGN_CODE** - campaign code for AdmitAd
- **ADMITAD_ACTION_CODE** - action code for AdmitAd (integer, example: *1*)
- **PRIME_LEAD_PATH** - secret path in url for PrimeLead
- **LEADS_SU_TOKEN** - token for LeadsSu
- **LETMEADS_PATH** - part of path for Letmeads postback url
- **LINK_PROFIT_CAMPAIGN_ID** - unique identifier for LinkProfit

If one of key for some CPA network not set 
postback requests for this network will not be done. 

### Lead parsing

There is an ability to parse leads from passed url.
You can use either some unique parser for needle CPA network or use [Parsers Chain](./src/Lead/Parser/Chain.php)
which runs all configured parsers.
If the CPA network is detected, you'll receive [Lead Information](./src/Lead/Info.php).
In another case `null` will be returned.

Here's an example of single parser usage:
```php
<?php

use Wearesho\Bobra\Cpa\AdmitAd;

/** @var string $url */

$parser = new AdmitAd\Lead\Parser();
$info = $parser->parse($url);
```

As said before, you can run several parsers by using [Parsers Chain](./src/Lead/Parser/Chain.php):

```php
<?php

use Wearesho\Bobra\Cpa;

/** @var string $url */

$parserChain = new Cpa\Lead\Parser\Chain([
    'parsers' => [
        Cpa\AdmitAd\Lead\Parser::class,
        Cpa\Cashka\Lead\Parser::class,
    ],
]);

$info = $parserChain->parse($url);

``` 

You can also configure parser in bootstrap

```php
<?php

// config/main.php

use Wearesho\Bobra\Cpa;

return [
    // ...
    'bootstrap' => [
        'cpa' => [
            'class' => Cpa\Bootstrap::class,
            'parser' => [
                'class' => Cpa\Lead\Parser\Chain::class,
                'parsers' => [
                    Cpa\AdmitAd\Lead\Parser::class,
                    Cpa\Cashka\Lead\Parser::class,
                    // other parsers
                ],
            ],             
        ],        
    ],
];

```

Parser chain with all integrated CPA networks will be applied in bootstrap by default.

### URL query format

Here is examples of URL query format that is required by each CPA network parser.
Important! This formats are compatible with backend lead parsing.
There can be differences in requirements with [frontend library](https://github.com/wearesho-team/bobra-cpa-frontend).

- Admit Ad - ?admitad_uid=...
- Cashka - ?utm_source=cashka&transaction_id=...
- Do Affiliate - ?utm_source=doaff&v=...
- Fin Line - ?utm_source=finline&clickid=...
- Lead Gid - ?utm_source=leadgid&click_id=...
- Leads Su - ?utm_source=leads-su&transaction_id=...
- Letmeads - ?letmeads_ref=...
- Loan Gate - ?afclick=...
- Prime Lead - ?utm_source=primelead&transaction_id=...
- Sales Doubler - ?utm_source=salesdoubler|cpanet_salesdubler|cpanet_salesdoubler&aff_sub=...

## Contribution
### Add new CPA
To add new CPA network you have to:
- add constant to [Lead\Source](./src/Lead/Source.php) interface
- implement model for lead creating
(example [DoAffiliate\LeadModel](./src/DoAffiliate/LeadModel.php)
- add source to [Web\Controller](./src/Web/Controller.php) sources configuration
- implement [Conversion\SendServiceInterface](./src/Conversion/SendServiceInterface.php)
using [Conversion\SendServiceTrait](./src/Conversion/SendServiceTrait.php)
(example [DoAffiliate\SendService](./src/DoAffiliate/SendService.php))
- add send service to [Conversion\Service](src/Conversion/Sync/Service.php)
senders configuration
- add tests for implemented classes
- extend CPA networks list in [README](./README.md#Integrated)
- if use environment configuration extend configuration block in [README](./README.md#Configuration)

### Tests
Run tests:
```bash
composer test
```

### Linting
This project uses PSR-2 for code style.
To check use:
```bash
composer lint
```

## Contributors
- [Alexander <horat1us> Letnikow](mailto:reclamme@gmail.com)

## License
[MIT](./LICENSE)
