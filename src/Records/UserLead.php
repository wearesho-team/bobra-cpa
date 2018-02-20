<?php

namespace Wearesho\Bobra\Cpa\Records;

use Horat1us\Yii\Validators\ConstRangeValidator;
use paulzi\jsonBehavior\JsonBehavior;
use paulzi\jsonBehavior\JsonField;
use paulzi\jsonBehavior\JsonValidator;
use yii\db\ActiveRecord;

/**
 * Class UserLead
 * @package Wearesho\Bobra\Cpa\Records
 *
 * @property string $id [integer]
 * @property string $user_id [integer]
 * @property string $source
 * @property JsonField $config [JSON]
 */
class UserLead extends ActiveRecord
{
    public const SOURCE_SALES_DOUBLER = 'salesDoubler';

    public function rules()
    {
        return [
            [['user_id', 'source', 'config'], 'required',],
            ['user_id', 'integer',],
            ['source', 'string',],
            ['source', ConstRangeValidator::class,],
            ['config', JsonValidator::class,],
        ];
    }

    public function behaviors()
    {
        return [
            'json' => [
                'class' => JsonBehavior::class,
                'attributes' => ['config',],
            ],
        ];
    }
}
