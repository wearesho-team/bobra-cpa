<?php

namespace Wearesho\Bobra\Cpa\Records;

use paulzi\jsonBehavior\JsonBehavior;
use paulzi\jsonBehavior\JsonValidator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class UserLeadConversion
 * @package Wearesho\Bobra\Cpa\Records
 *
 * @property int $id [integer]
 * @property string $user_lead_id [integer]
 * @property string $conversion_id
 * @property string $request [JSON]
 * @property string $response [JSON]
 *
 * @property UserLead $lead
 */
class UserLeadConversion extends ActiveRecord
{
    public function rules()
    {
        return [
            [['user_lead_id', 'conversion_id', 'request'], 'required',],
            [['user_lead_id'], 'exist',
                'targetClass' => UserLead::class,
                'targetAttribute' => 'id',
            ],
            ['conversion_id', 'string',],
            [['request', 'response'], JsonValidator::class,],
            [['conversion_id'], 'unique',],
        ];
    }

    public function behaviors()
    {
        return [
            'json' => [
                'class' => JsonBehavior::class,
                'attributes' => ['request', 'response',],
            ],
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
