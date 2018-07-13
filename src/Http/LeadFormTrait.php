<?php

namespace Wearesho\Bobra\Cpa\Http;

use Carbon\Carbon;
use Horat1us\Yii\Exceptions\ModelException;

use Wearesho\Bobra\Cpa\CpaPermission;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Yii\Http\Behaviors\AccessControl;

use yii\filters\AccessRule;

/**
 * Trait LeadFormTrait
 * @package Wearesho\Bobra\Cpa\Http
 *
 * @property-read string $source
 */
trait LeadFormTrait
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'class' => AccessRule::class,
                        'permissions' => [CpaPermission::CREATE_LEADS,],
                    ],
                ],
            ],
        ];
    }

    final public function formName()
    {
        return "LeadForm";
    }

    final protected function generateResponse(): array
    {
        $lead = $this->save($this->source);
        return [
            'id' => $lead->id,
        ];
    }

    final protected function save(string $source): UserLead
    {
        $lead = UserLead::find()
            ->andWhere(['=', 'user_id', \Yii::$app->user->id,])
            ->andWhere(['=', 'source', $source,])
            ->one();

        if (!$lead instanceof UserLead) {
            $lead = new UserLead([
                'user_id' => \Yii::$app->user->id,
                'source' => $source,
            ]);
        } else {
            $lead->created_at = Carbon::now()->toDateTimeString();
        }

        $lead->config = $this->getConfig();

        return ModelException::saveOrThrow($lead);
    }

    abstract protected function getSource(): string;

    protected function getConfig(): array
    {
        return $this->getAttributes();
    }
}
