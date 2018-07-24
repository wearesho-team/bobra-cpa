# Bobra CPA Integrations

## Integrated
- [SalesDoubler](./src/SalesDoubler)
- [DoAffiliate](./src/DoAffiliate)
- [LoanGate](./src/LoanGate)
- [FinLine](./src/FinLine)
- [AdmitAd](./src/AdmitAd)
- [Cashka](./src/Cashka)
- [PrimeLead](./src/PrimeLead)
- [Leads.SU](./src/LeadsSu)

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
- **PRIME_LEAD_PATH** - secret path in url for PrimeLead
- **LEADS_SU_TOKEN** - token for LeadsSu

If one of key for some CPA network not set 
postback requests for this network will not be done. 


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
