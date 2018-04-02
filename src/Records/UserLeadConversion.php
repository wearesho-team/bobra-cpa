<?php

namespace Wearesho\Bobra\Cpa\Records;

use Carbon\Carbon;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class UserLeadConversion
 * @package Wearesho\Bobra\Cpa\Records
 *
 * @property int $id [integer]
 * @property string $user_lead_id [integer]
 * @property string $conversion_id
 * @property array $request [JSON]
 * @property array $response [JSON]
 * @property string $created_at
 *
 * @property UserLead $lead
 */
class UserLeadConversion extends ActiveRecord
{
    public function behaviors()
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

    public function rules()
    {
        return [
            [['user_lead_id', 'conversion_id', 'request'], 'required',],
            [['user_lead_id'], 'exist',
                'targetClass' => UserLead::class,
                'targetAttribute' => 'id',
            ],
            ['conversion_id', 'string',],
            [['request', 'response'], 'safe',],
            [['conversion_id'], 'unique',],
            ['created_at', 'date', 'format' => 'php:Y-m-d H:i:s',],
        ];
    }

    public function getLead(): ActiveQuery
    {
        return $this->hasOne(UserLead::class, ['id' => 'user_lead_id']);
    }

    public function setLead(UserLead $lead = null): self
    {
        $this->user_lead_id = $lead ? $lead->id : null;
        $this->populateRelation('lead', $lead);
        return $this;
    }

    public function isExists(): bool
    {
        return static::find()->andWhere(['=', 'conversion_id', $this->conversion_id])->exists();
    }
}
