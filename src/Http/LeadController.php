<?php

namespace Wearesho\Bobra\Cpa\Http;

use Wearesho\Bobra\Cpa\Http\Forms;
use Wearesho\Yii\Http\Controller;

/**
 * Class LeadController
 * @package Wearesho\Bobra\Cpa\Http
 */
class LeadController extends Controller
{
    public $actions = [
        'sales-doubler' => ['post' => Forms\SalesDoublerForm::class,],
        'loan-gate' => ['post' => Forms\LoanGateForm::class,],
        'do-affiliate' => ['post' => Forms\DoAffiliateForm::class,],
        'fin-line' => ['post' => Forms\FinLineForm::class,],
        'cashka' => ['post' => Forms\CashkaForm::class,],
        'admit-ad' => ['post' => Forms\AdmitAdForm::class,],
        'prime-lead' => ['post' => Forms\PrimeLeadForm::class,],
        'leads-su' => ['post' => Forms\LeadsSuForm::class,],
    ];
}
