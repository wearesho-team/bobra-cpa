<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Services;

use GuzzleHttp\ClientInterface;
use Horat1us\Yii\Exceptions\ModelException;
use paulzi\jsonBehavior\JsonField;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Bobra\Cpa\Records\UserLeadConversion;
use Wearesho\Bobra\Cpa\Services\ConversionService;
use Wearesho\Bobra\Cpa\Services\SalesDoublerSendService;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\GuzzleExceptionClientMock;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\RequestExceptionClientMock;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\UserLeadMock;

/**
 * Class ConversionSenderTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Services
 */
class ConversionServiceTest extends AbstractTestCase
{
    /** @var UserLead */
    protected $lead;

    /** @var ConversionService */
    protected $service;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        getenv(SalesDoublerSendService::ENV_TOKEN_KEY)
        || putenv(SalesDoublerSendService::ENV_TOKEN_KEY . '=testToken');
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     * @throws \yii\base\InvalidConfigException
     */
    protected function setUp()
    {
        parent::setUp();
        $lead = new UserLeadMock();

        $lead->user_id = 0;
        $lead->source = Userlead::SOURCE_SALES_DOUBLER;
        $lead->config = new JsonField([
            'test' => 'test',
        ]);

        ModelException::saveOrThrow($lead);

        $this->lead = $lead;
        $this->service = \Yii::$container->get(ConversionService::class);
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testCorrectRegisteringConversion()
    {
        $this->assertFalse(
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->exists()
        );

        $this->service->register($this->lead, 'testConversionId');

        $this->assertTrue(
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->exists()
        );
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testSendingDuplicateConversion()
    {
        $conversionId = 'conversionId';
        $this->service->register($this->lead, $conversionId);
        $this->assertTrue(
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->exists()
        );

        $this->service->register($this->lead, $conversionId);
        $this->assertEquals(
            1,
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->count()
        );
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testSendingConversionWithDisabledSender()
    {
        putenv(SalesDoublerSendService::ENV_TOKEN_KEY);
        $this->service->register($this->lead, 'testConversionId');
        $this->assertFalse(
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->exists()
        );
        putenv(SalesDoublerSendService::ENV_TOKEN_KEY . '=testToken');
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testInvalidSource()
    {
        $this->lead->source = UserLeadMock::SOURCE_TEST;
        $this->service->register($this->lead, 'conversionId');
        $this->assertFalse(
            UserLeadConversion::find()
                ->innerJoinWith('lead')
                ->andWhere(['=', 'user_lead_id', $this->lead->id,])
                ->exists()
        );
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testGuzzleException()
    {
        \Yii::$container->set(
            ClientInterface::class,
            GuzzleExceptionClientMock::class
        );

        $this->service->register($this->lead, 'conversionId');
        $conversion = UserLeadConversion::find()
            ->andWhere(['=', 'user_lead_id', $this->lead->id,])
            ->one();

        $this->assertInstanceOf(UserLeadConversion::class, $conversion);
        $this->assertInstanceOf(JsonField::class, $conversion->response);
        $this->assertTrue($conversion->response->isEmpty());
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testRequestException()
    {
        \Yii::$container->set(
            ClientInterface::class,
            RequestExceptionClientMock::class
        );

        $this->service->register($this->lead, 'conversionId');
        $conversion = UserLeadConversion::find()
            ->andWhere(['=', 'user_lead_id', $this->lead->id,])
            ->one();

        $this->assertInstanceOf(UserLeadConversion::class, $conversion);
        $this->assertInstanceOf(JsonField::class, $conversion->response);
        $array = $conversion->response->toArray();
        $this->assertArrayHasKey('code', $array);
        $this->assertEquals($array['code'], RequestExceptionClientMock::STATUS_CODE);
    }
}
