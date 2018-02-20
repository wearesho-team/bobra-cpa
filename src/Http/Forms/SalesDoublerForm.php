<?php

namespace Wearesho\Bobra\Cpa\Http\Forms;

use Wearesho\Bobra\Cpa\Http\LeadFormTrait;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Form;

/**
 * Class SalesDoublerForm
 * @package Wearesho\Bobra\Cpa\Http\Forms
 */
class SalesDoublerForm extends Form
{
    use LeadFormTrait;

    /** @var string */
    public $clickId;

    /**
     * Web master identifier
     * @var string
     */
    public $aid;

    public function rules()
    {
        return [
            ['clickId', 'required',],
            [['clickId', 'aid'], 'string',]
        ];
    }

    protected function getSource(): string
    {
        return UserLead::SOURCE_SALES_DOUBLER;
    }
}
