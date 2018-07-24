<?php

namespace Wearesho\Bobra\Cpa;

use Carbon\Carbon;
use yii\behaviors\TimestampBehavior;
use yii\db;

/**
 * Class Lead
 * @package Wearesho\Bobra\Cpa
 * @property string $id [integer]
 * @property string $user_id [integer]
 * @property string $source
 * @property array $config [JSON]
 * @property int $created_at [timestamp]
 * @property string|null $product [varchar(64)]
 */
class Lead extends db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'user_lead';
    }

    public function behaviors(): array
    {
        return [
            'ts' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => null,
                'value' => function (): string {
                    return Carbon::now()->toDateTimeString();
                },
            ],
        ];
    }

    public function rules(): array
    {
        // todo: add source const validator
        return [
            [['user_id', 'source', 'config'], 'required',],
            [['user_id'], 'integer',],
            [['source'], 'string',],
            [['config'], 'safe',],
            [['created_at'], 'date', 'format' => 'php:Y-m-d H:i:s',],
            [['product',], 'string', 'max' => 64,],
        ];
    }
}
