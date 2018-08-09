<?php

namespace Wearesho\Bobra\Cpa\Letmeads;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\Letmeads
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $letmeadsRef;

    public function rules(): array
    {
        return [
            [['letmeadsRef',], 'required',],
            [['letmeadsRef',], 'string',],
        ];
    }
}
