<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class DoAffiliateForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class DoAffiliateForm extends Form
{
    use LeadFormTrait;

    public $visitor;

    public function rules()
    {
        return [
            [['visitor',], 'required',],
            [['visitor',], 'string',],
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_DO_AFFILIATE;
    }

    protected function getConfig(): array
    {
        return array_merge($this->getAttributes(), [
            'user' => \Yii::$app->user->id,
        ]);
    }
}
