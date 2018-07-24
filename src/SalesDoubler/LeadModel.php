<?php

namespace Wearesho\Bobra\Cpa\SalesDoubler;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\SalesDoubler
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $clickId;

    /**
     * Web master identifier
     * @var string
     */
    public $aid;

    public function rules(): array
    {
        return [
            ['clickId', 'required',],
            [['clickId', 'aid'], 'string',]
        ];
    }
}
