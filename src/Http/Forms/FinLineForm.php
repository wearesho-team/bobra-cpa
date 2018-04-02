<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class FinLineForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class FinLineForm extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $clickId;

    public function rules()
    {
        return [
            [['clickId',], 'required',],
            [['clickId',], 'string',],
        ];
    }


    protected function getSource(): string
    {
        return UserLead::SOURCE_FIN_LINE;
    }
}
