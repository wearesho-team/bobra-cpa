<?php

namespace Wearesho\Bobra\Cpa\Records;

use Carbon\Carbon;
use Horat1us\Yii\Validators\ConstRangeValidator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class UserLead
 * @package Wearesho\Bobra\Cpa\Records
 *
 * @property string $id [integer]
 * @property string $user_id [integer]
 * @property string $source
 * @property array $config [JSON]
 * @property string $created_at
 */
class UserLead extends ActiveRecord
{
    public const SOURCE_SALES_DOUBLER = 'salesDoubler';
    public const SOURCE_LOAN_GATE = 'loanGate';
    public const SOURCE_DO_AFFILIATE = 'doAffiliate';
    public const SOURCE_FIN_LINE = 'finLine';
    public const SOURCE_CASHKA = 'cashka';
    public const SOURCE_ADMIT_AD = 'admitAd';
    public const SOURCE_PRIME_LEAD = 'primeLead';
    public const SOURCE_LEADS_SU = 'leadsSu';

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
            [['user_id', 'source', 'config'], 'required',],
            ['user_id', 'integer',],
            ['source', 'string',],
            ['source', ConstRangeValidator::class,],
            ['config', 'safe',],
            ['created_at', 'date', 'format' => 'php:Y-m-d H:i:s',],
        ];
    }
}