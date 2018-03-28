<?php

namespace Wearesho\Bobra\Cpa\Services;

use Horat1us\Yii\Exceptions\ModelException;
use Horat1us\Yii\Interfaces\ModelExceptionInterface;

use Psr\Http\Message\ResponseInterface;
use Wearesho\Bobra\Cpa\Factories\ConversionSenderFactory;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Bobra\Cpa\Records\UserLeadConversion;

use yii\base\Component;

/**
 * Class ConversionService
 * @package Wearesho\Bobra\Cpa\Services
 */
class ConversionService extends Component
{
    /** @var ConversionSenderFactory */
    protected $factory;

    public function __construct(ConversionSenderFactory $factory, array $config = [])
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * @param UserLead $lead
     * @param string $conversionId
     * @throws ModelExceptionInterface
     */
    public function register(UserLead $lead, string $conversionId): void
    {
        try {
            $sender = $this->factory->instantiate($lead->source);
        } catch (\InvalidArgumentException $exception) {
            \Yii::warning($exception->getMessage(), static::class);
            return;
        }

        if (!$sender->isEnabled()) {
            \Yii::info("Trying to send conversion through disabled sender.", static::class);
            return;
        }

        $conversion = new UserLeadConversion();
        $conversion->lead = $lead;
        $conversion->conversion_id = $conversionId;

        if ($conversion->isExists()) {
            \Yii::info("Skipping sending duplicate conversion {$conversionId}", static::class);
            return;
        }

        $result = $sender->send($conversionId, $lead->config);

        $conversion->request = [
            'method' => $result->getRequest()->getMethod(),
            'uri' => $result->getRequest()->getUri(),
            'body' => $result->getRequest()->getBody()->getContents(),
        ];

        $response = $result->getResponse();
        if ($response instanceof ResponseInterface) {
            $conversion->response = [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } else {
            \Yii::error("Response for conversion $conversionId does not formed well.", static::class);
        }

        \Yii::info("Conversion $conversionId sent.", static::class);

        ModelException::saveOrThrow($conversion);
    }

    /**
     * This method is useful to easy handling conversion events.
     * It will use current user id as conversion id.
     *
     * For example you can write in your component:
     *
     * ```php
     * <?php
     * use Wearesho\Bobra\Cpa\Services\ConversionService;
     *
     * class A extends \yii\base\Component {
     *  public function init() {
     *      $this->on('conversion', [ConversionService::class, 'catchEvent']);
     *  }
     *
     *  public function somethingDone() {
     *      $this->trigger('conversion');
     *  }
     * }
     * ```
     */
    public static function catchEvent(): void
    {
        $user = \Yii::$app->user->id;
        if (!$user) {
            \Yii::warning("Trying to send conversion without logged in user", static::class);
            return;
        }
        $lead = UserLead::find()->andWhere(['=', 'user_id', $user])->one();
        if (!$lead instanceof UserLead) {
            return;
        }

        /** @var static $self */
        $self = \Yii::$container->get(static::class);
        $self->register($lead, $user);
    }
}
