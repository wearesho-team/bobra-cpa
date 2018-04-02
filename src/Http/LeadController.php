<?php

namespace Wearesho\Bobra\Cpa\Http;

use Wearesho\Bobra\Cpa\Http\Forms\DoAffiliateForm;
use Wearesho\Bobra\Cpa\Http\Forms\LoanGateForm;
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
    ];
}
