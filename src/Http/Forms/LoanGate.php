<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class LoanGate
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class LoanGate extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $afclick;

    public function rules(): array
    {
        return [
            [['afclick',], 'required',],
            [['afclick',], 'string',],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_LOAN_GATE;
    }
}
