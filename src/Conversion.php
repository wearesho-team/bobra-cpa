<?php

namespace Wearesho\Bobra\Cpa;

use Carbon\Carbon;
use yii\behaviors\TimestampBehavior;
use yii\db;

/**
 * Class Conversion
 * @package Wearesho\Bobra\Cpa
 *
 * @property Lead $lead
 *
 * @property string $id [integer]
 * @property string $user_lead_id [integer]
 * @property string $conversion_id
 * @property array $request [JSON]
 * @property array $response [JSON]
 */
class Conversion extends db\ActiveRecord implements ConversionInterface
{
    public static function tableName(): string
    {
        return 'user_lead_conversion';
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
        return [
            [['user_lead_id', 'conversion_id', 'request'], 'required',],
            [
                ['user_lead_id'],
                'exist',
                'targetRelation' => 'lead',
            ],
            ['conversion_id', 'string',],
            [['request', 'response'], 'safe',],
            [['conversion_id'], 'unique',],
            ['created_at', 'date', 'format' => 'php:Y-m-d H:i:s',],
        ];
    }

    public function getLead(): db\ActiveQuery
    {
        return $this->hasOne(Lead::class, ['id' => 'user_lead_id']);
    }

    public function setLead(Lead $lead = null): self
    {
        $this->user_lead_id = $lead ? $lead->id : null;
        $this->populateRelation('lead', $lead);
        return $this;
    }

    public function isExists(): bool
    {
        return static::find()->andWhere(['=', 'conversion_id', $this->conversion_id])->exists();
    }

    // region ConversionInterface
    public function getId(): string
    {
        return $this->conversion_id;
    }

    public function getUser(): int
    {
        return $this->lead->user_id;
    }

    public function getConfig(): array
    {
        return $this->lead->config;
    }

    public function getProduct(): ?string
    {
        return $this->lead->product;
    }
    // endregion
}
