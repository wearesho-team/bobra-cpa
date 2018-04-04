<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class CashkaForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class CashkaForm extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $transactionId;

    public function rules()
    {
        return [
            ['transactionId', 'required',],
            ['transactionId', 'string',],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_CASHKA;
    }
}
