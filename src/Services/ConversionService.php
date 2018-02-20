<?php

namespace Wearesho\Bobra\Cpa\Services;

use Horat1us\Yii\Exceptions\ModelException;

use paulzi\jsonBehavior\JsonField;

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
     * @param string $conversion
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function register(UserLead $lead, string $conversion): void
    {
        try {
            $sender = $this->factory->instantiate($lead->source);
        } catch (\InvalidArgumentException $exception) {
            \Yii::warning($exception->getMessage(), static::class);
            return;
        }

        if (!$sender->isEnabled()) {
            \Yii::info("Trying to send conversion through disabled sender.", static::class);
        }

        $result = $sender->send($conversion, $lead->config->toArray());

        $conversion = new UserLeadConversion();
        $conversion->lead = $lead;
        $conversion->conversion_id = $conversion;

        if ($conversion->isExists()) {
            \Yii::trace("Skipping sending duplicate conversion {$conversion}", static::class);
            return;
        }

        $conversion->request = new JsonField([
            'method' => $result->getRequest()->getMethod(),
            'uri' => $result->getRequest()->getUri(),
            'body' => $result->getRequest()->getBody()->getContents(),
        ]);

        if ($response = $result->getResponse()) {
            \Yii::error("Response for conversion $conversion does not formed well.", static::class);
            $conversion->response = new JsonField([
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ]);
        }

        \Yii::trace("Conversion $conversion sent.", static::class);

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
        $lead = UserLead::find()->andWhere(['=', 'user_id', $user]);
        if (!$lead instanceof UserLead) {
            return;
        }

        /** @var static $self */
        $self = \Yii::$container->get(static::class);
        $self->register($lead, $user);
    }
}
