<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class PrimeLeadForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class PrimeLeadForm extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $transactionId;

    public function rules(): array
    {
        return [
            ['transactionId', 'required',],
            ['transactionId', 'string',],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_PRIME_LEAD;
    }
}
