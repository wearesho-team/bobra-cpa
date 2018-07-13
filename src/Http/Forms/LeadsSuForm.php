<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http;

/**
 * Class LeadsSuForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class LeadsSuForm extends Http\Form
{
    use LeadFormTrait;

    /** @var string */
    public $transactionId;

    public function rules(): array
    {
        return [
            [['transactionId',], 'required',],
            [['transactionId',], 'string', 'length' => 32,],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_LEADS_SU;
    }
}
