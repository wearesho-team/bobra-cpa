<?php

namespace Wearesho\Bobra\Cpa\Http;

use Wearesho\Bobra\Cpa\Http\Forms\AdmitAdForm;
use Wearesho\Bobra\Cpa\Http\Forms\CashkaForm;
use Wearesho\Bobra\Cpa\Http\Forms\DoAffiliateForm;
use Wearesho\Bobra\Cpa\Http\Forms\FinLineForm;
use Wearesho\Bobra\Cpa\Http\Forms\LoanGateForm;
use Wearesho\Bobra\Cpa\Http\Forms\PrimeLeadForm;
use Wearesho\Bobra\Cpa\Http\Forms\SalesDoublerForm;
use Wearesho\Yii\Http\Controller;

/**
 * Class LeadController
 * @package Wearesho\Bobra\Cpa\Http
 */
class LeadController extends Controller
{
    public $actions = [
        'sales-doubler' => ['post' => SalesDoublerForm::class,],
        'loan-gate' => ['post' => LoanGateForm::class,],
        'do-affiliate' => ['post' => DoAffiliateForm::class,],
        'fin-line' => ['post' => FinLineForm::class,],
        'cashka' => ['post' => CashkaForm::class,],
        'admit-ad' => ['post' => AdmitAdForm::class,],
        'prime-lead' => ['post' => PrimeLeadForm::class,],
    ];
}
