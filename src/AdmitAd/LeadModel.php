<?php

namespace Wearesho\Bobra\Cpa\AdmitAd;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\AdmitAd
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $uid;

    public function rules(): array
    {
        return [
            ['uid', 'required',],
            ['uid', 'string',],
        ];
    }
}
