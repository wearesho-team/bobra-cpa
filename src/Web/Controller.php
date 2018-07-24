<?php

namespace Wearesho\Bobra\Cpa\Web;

use Carbon\Carbon;
use Horat1us\Yii\Behaviors\OptionsRequestBehavior;
use Horat1us\Yii\Exceptions\ModelException;
use yii\filters;
use yii\helpers;
use yii\web;
use yii\di;
use yii\base;
use Wearesho\Bobra\Cpa;

/**
 * Class Controller
 * @package Wearesho\Bobra\Cpa\Web
 */
class Controller extends web\Controller
{
    /**
     * @var array[]|string[]|Cpa\DoAffiliate\LeadModel[] definitions
     */
    public $sources = [
        Cpa\Lead\Source::DO_AFFILIATE => Cpa\DoAffiliate\LeadModel::class,
        Cpa\Lead\Source::ADMIT_AD => Cpa\AdmitAd\LeadModel::class,
        Cpa\Lead\Source::FIN_LINE => Cpa\FinLine\LeadModel::class,
        Cpa\Lead\Source::LEADS_SU => Cpa\LeadsSu\LeadModel::class,
    ];

    /**
     * @var string Header name will be used to fetch current product code
     * Set to null to disable
     */
    public $productHeader = 'Sho-Product';

    /** @var string|array|web\User definition */
    public $user = 'user';

    /**
     * @throws base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->user = di\Instance::ensure($this->user, web\User::class);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => filters\AccessControl::class,
                'rules' => [
                    [
                        'class' => filters\AccessRule::class,
                        'actions' => ['index',],
                        'roles' => [Cpa\Permissions::CREATE_LEADS,],
                    ],
                ],
            ],
            'verb' => [
                'class' => filters\VerbFilter::class,
                'actions' => [
                    'index' => ['post', 'options',],
                ],
            ],
            'cors' => [
                'class' => filters\Cors::class,
            ],
            'options' => [
                'class' => OptionsRequestBehavior::class,
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws web\BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        \Yii::$app->response->format = web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @param string $source
     * @return array
     * @throws \Horat1us\Yii\Interfaces\ModelExceptionInterface
     * @throws base\InvalidConfigException
     * @throws web\BadRequestHttpException
     * @throws web\NotFoundHttpException
     */
    public function actionIndex(string $source): array
    {
        if (!array_key_exists($source, $this->sources)) {
            $source = lcfirst(helpers\Inflector::id2camel($source));
        }

        if (!array_key_exists($source, $this->sources)) {
            throw new web\NotFoundHttpException("Source $source does not exist");
        }

        /** @var base\Model $model */
        $model = di\Instance::ensure($this->sources[$source], base\Model::class);

        if (!$model->load(\Yii::$app->request->bodyParams, 'LeadForm') || !$model->validate()) {
            \Yii::$app->response->statusCode = 400;
            return [
                'errors' => $model->errors,
            ];
        }

        $lead = $this->save($source, $model);

        return [
            'id' => $lead->id,
        ];
    }

    /**
     * @param string $source
     * @param base\Model $config
     * @return Cpa\Lead
     * @throws web\BadRequestHttpException
     * @throws \Horat1us\Yii\Interfaces\ModelExceptionInterface
     */
    protected function save(string $source, base\Model $config): Cpa\Lead
    {
        $userId = $this->user->id;

        $query = Cpa\Lead::find()
            ->andWhere(['=', 'user_id', $userId,])
            ->andWhere(['=', 'source', $source,]);

        $productCode = $this->productCode();
        if (!is_null($productCode)) {
            $query->andWhere(['=', 'product', $productCode]);
        } else {
            $query->andWhere('product is null');
        }

        $lead = $query
            ->one();

        if (!$lead instanceof Cpa\Lead) {
            \Yii::$app->response->statusCode = 201;
            $lead = new Cpa\Lead([
                'user_id' => $userId,
                'source' => $source,
            ]);
        } else {
            $lead->created_at = Carbon::now()->toDateTimeString();
        }

        $lead->product = $productCode;
        $lead->config = $config->toArray();

        ModelException::saveOrThrow($lead);
        return $lead;
    }

    /**
     * @return null|string
     * @throws web\BadRequestHttpException
     */
    protected function productCode(): ?string
    {
        if (is_null($this->productHeader)) {
            return null;
        }

        $productCode = \Yii::$app->request->headers->get($this->productHeader);
        if (empty($productCode)) {
            throw new web\BadRequestHttpException(
                "Missing product code in " . $this->productHeader . " header"
            );
        }

        return $productCode;
    }
}
