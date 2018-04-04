<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class AdmitAdForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class AdmitAdForm extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $uid;

    public function rules(): array
    {
        return [
            ['uid', 'required',],
            ['uid', 'string',],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_ADMIT_AD;
    }
}
