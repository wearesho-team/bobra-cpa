<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Web;

use Carbon\Carbon;
use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\web;

/**
 * Class ControllerTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Web
 * @internal
 */
class ControllerTest extends Cpa\Tests\AbstractTestCase
{
    public const USER_ID = 10;

    /** @var Cpa\Web\Controller */
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        web\Request::class;
        $this->app->set('request', new web\Request([
            'enableCsrfCookie' => false,
            'enableCookieValidation' => false,
        ]));
        $this->app->set('response', new web\Response);
        $this->app->set('user', new class extends web\User
        {
            public $enableSession = false;

            public function init()
            {
            }

            public function getId()
            {
                return ControllerTest::USER_ID;
            }
        });
        $this->controller = new Cpa\Web\Controller(
            'test',
            new base\Module('module')
        );
    }

    public function testBeforeActionResponseFormat(): void
    {
        $this->controller->beforeAction(new base\Action('id', $this->controller));
        $this->assertEquals(
            \Yii::$app->response->format,
            web\Response::FORMAT_JSON
        );
    }

    /**
     * @expectedException \yii\web\NotFoundHttpException
     * @expectedExceptionMessage Source unknownSource does not exist
     */
    public function testInvalidSource(): void
    {
        $this->controller->sources = [];
        $this->controller->actionIndex('unknown-source');
    }

    public function testInvalidValidation(): void
    {
        $this->controller->sources = [
            'test' => new class extends base\Model
            {
                public $attribute = null;

                public function rules(): array
                {
                    return [
                        [['attribute',], 'required',],
                    ];
                }
            },
        ];
        $this->setBodyParams();
        $response = $this->controller->actionIndex('test');
        $this->assertEquals(400, $this->app->response->statusCode);
        $this->assertEquals(
            [
                'errors' => [
                    'attribute' => [
                        0 => 'Attribute cannot be blank.'
                    ],
                ],
            ],
            $response
        );
    }

    /**
     * @expectedException \yii\web\BadRequestHttpException
     * @expectedExceptionMessage Missing product code in X-Product header
     */
    public function testMissingProductCode(): void
    {
        $this->controller->productHeader = 'X-Product';
        $this->app->request->headers->remove('X-Product');
        $this->setBodyParams();
        $this->controller->sources = [
            'test' => new class extends base\Model
            {
            }
        ];
        $this->controller->actionIndex('test');
    }

    public function testNewLeadWithoutProduct(): void
    {
        $this->controller->productHeader = null;
        $this->setBodyParams();
        $this->controller->sources = [
            'test' => new class extends base\Model
            {
                public function toArray(array $fields = [], array $expand = [], $recursive = true)
                {
                    return [
                        'key' => 'mock',
                    ];
                }
            }
        ];

        // storing lead with product to make sure product query condition works fine
        $leadWithProduct = new Cpa\Lead([
            'user_id' => static::USER_ID,
            'source' => 'test',
            'product' => 'default',
            'config' => [
                'key' => 'value',
            ],
        ]);
        ModelException::saveOrThrow($leadWithProduct);

        $response = $this->controller->actionIndex('test');
        $this->assertEquals(
            201,
            $this->app->response->statusCode
        );
        $this->assertArrayHasKey('id', $response);

        $savedLead = Cpa\Lead::findOne($response['id']);
        $this->assertInstanceOf(Cpa\Lead::class, $savedLead);
        $this->assertEquals(
            static::USER_ID,
            $savedLead->user_id
        );
        $this->assertEquals(
            'test',
            $savedLead->source
        );
        $this->assertEquals(
            [
                'key' => 'mock',
            ],
            $savedLead->config
        );
        $this->assertEmpty($savedLead->product);
        $leadWithProduct->delete();
    }

    public function testDuplicatedLeadWithoutProduct(): void
    {
        $this->controller->productHeader = null;
        $this->setBodyParams();
        $this->controller->sources = [
            'test' => new class extends base\Model
            {
                public function toArray(array $fields = [], array $expand = [], $recursive = true)
                {
                    return [
                        'key' => 'value2',
                    ];
                }
            }
        ];

        $previouslySavedLead = new Cpa\Lead([
            'user_id' => static::USER_ID,
            'source' => 'test',
            'config' => [
                'key' => 'value',
            ],
        ]);
        ModelException::saveOrThrow($previouslySavedLead);

        Carbon::setTestNow(Carbon::now()->addSecond(1));
        $response = $this->controller->actionIndex('test');
        Carbon::setTestNow();
        $this->assertEquals(200, $this->app->response->statusCode);
        $this->assertArrayHasKey('id', $response);

        $updatedLead = Cpa\Lead::findOne($response['id']);
        $this->assertInstanceOf(Cpa\Lead::class, $updatedLead);

        $this->assertEquals($response['id'], $previouslySavedLead->id);
        $this->assertGreaterThan($previouslySavedLead->created_at, $updatedLead->created_at);
        $this->assertNotEquals($previouslySavedLead->config, $updatedLead->config);
        $this->assertEquals(
            [
                'key' => 'value2',
            ],
            $updatedLead->config
        );
    }

    public function testNewLeadWithProduct(): void
    {
        $this->controller->productHeader = 'X-Product';
        $this->app->request->headers->add('X-Product', 'default');
        $this->setBodyParams();

        // creating lead without product to make sure query condition works fine
        $leadWithoutProduct = new Cpa\Lead([
            'user_id' => static::USER_ID,
            'source' => 'test',
            'config' => [
                'key' => 'value',
            ],
        ]);
        ModelException::saveOrThrow($leadWithoutProduct);

        $this->controller->sources = [
            'test' => new class extends base\Model
            {
                public function toArray(array $fields = [], array $expand = [], $recursive = true)
                {
                    return [
                        'key' => 'product',
                    ];
                }
            }
        ];

        $response = $this->controller->actionIndex('test');
        $this->assertEquals(
            201,
            $this->app->response->statusCode
        );
        $this->assertArrayHasKey('id', $response);

        $savedLead = Cpa\Lead::findOne($response['id']);
        $this->assertInstanceOf(Cpa\Lead::class, $savedLead);
        $this->assertEquals(
            static::USER_ID,
            $savedLead->user_id
        );
        $this->assertEquals(
            'test',
            $savedLead->source
        );
        $this->assertEquals(
            [
                'key' => 'product',
            ],
            $savedLead->config
        );
        $this->assertEquals('default', $savedLead->product);
    }

    protected function setBodyParams(): void
    {
        $this->app->request->setBodyParams([
            'LeadForm' => [],
        ]);
    }
}
