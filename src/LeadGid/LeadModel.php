<?php

namespace Wearesho\Bobra\Cpa\LeadGid;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\LeadGid
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $clickId;

    public function rules(): array
    {
        return [
            [
                ['clickId',],
                'required',
            ],
            [
                ['clickId',],
                'string',
            ],
        ];
    }
}
