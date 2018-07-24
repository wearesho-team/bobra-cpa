<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Conversion\Sync;

use GuzzleHttp\Psr7;
use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa;
use yii\log\Logger;

/**
 * Class ServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Conversion
 * @internal
 */
class ServiceTest extends Cpa\Tests\AbstractTestCase
{
    /** @var Cpa\Conversion\Sync\Service */
    protected $service;

    /** @var Logger */
    protected $logger;

    protected function setUp(): void
    {
        parent::setUp();
        \Yii::setLogger($this->logger = new Logger());
        $this->service = new Cpa\Conversion\Sync\Service();
    }

    public function testUnknownIdCaseLead(): void
    {
        $this->service->senders = [];
        $this->service->register(new Cpa\Lead(['source' => 'unknown-source']), 1);

        $this->assertArraySubset(
            [
                'Trying to send conversion through disabled sender: unknownSource',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            array_pop($this->logger->messages)
        );
        $this->assertArraySubset(
            [
                'Trying to send conversion with id case sender',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            array_pop($this->logger->messages)
        );
    }

    public function testDuplicateConversion(): void
    {
        $lead = new Cpa\Lead([
            'user_id' => 1,
            'source' => Cpa\Lead\Source::DO_AFFILIATE,
            'config' => ['key' => 'value',],
        ]);
        ModelException::saveOrThrow($lead);

        $conversionId = 1;
        $conversion = new Cpa\Conversion([
            'lead' => $lead,
            'conversion_id' => (string)$conversionId,
            'request' => [
                'key' => 'value',
            ],
        ]);
        ModelException::saveOrThrow($conversion);

        $this->service->register($lead, $conversionId);

        $this->assertArraySubset(
            [
                'Skipping sending duplicate conversion 1',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            array_pop($this->logger->messages)
        );

        $lead->delete();
        $conversion->delete();
    }

    public function testConversionWithResponse(): void
    {
        $this->service->senders = [
            'sample' => new class implements Cpa\Conversion\SendServiceInterface
            {
                public function send(Cpa\ConversionInterface $conversion): Cpa\PostbackTuple
                {
                    return new Cpa\PostbackTuple(
                        new Psr7\Request('post', 'https://wearesho.com', [], 'TEXT'),
                        new Psr7\Response(201, [], 'OK')
                    );
                }
            }
        ];

        $lead = new Cpa\Lead([
            'user_id' => 1,
            'source' => 'sample',
            'config' => ['key' => 'value',],
        ]);
        ModelException::saveOrThrow($lead);

        $conversionId = 1;
        $this->service->register($lead, $conversionId);
        $this->assertArraySubset(
            [
                'Conversion 1 sent.',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            $this->logger->messages[count($this->logger->messages) - 10]
        );

        $savedConversion = Cpa\Conversion::find()
            ->andWhere(['=', 'user_lead_id', $lead->id])
            ->andWhere(['=', 'conversion_id', (string)$conversionId])
            ->one();

        $this->assertInstanceOf(Cpa\Conversion::class, $savedConversion);

        $this->assertEquals(
            [
                'method' => 'POST',
                'uri' => 'https://wearesho.com',
                'body' => 'TEXT',
            ],
            $savedConversion->request
        );
        $this->assertEquals(
            [
                'code' => 201,
                'body' => 'OK',
            ],
            $savedConversion->response
        );
    }

    public function testConversionWithoutResponse(): void
    {
        $this->service->senders = [
            'sample' => new class implements Cpa\Conversion\SendServiceInterface
            {
                public function send(Cpa\ConversionInterface $conversion): Cpa\PostbackTuple
                {
                    return new Cpa\PostbackTuple(
                        new Psr7\Request('post', 'https://wearesho.com', [], 'TEXT')
                    );
                }
            }
        ];

        $lead = new Cpa\Lead([
            'user_id' => 1,
            'source' => 'sample',
            'config' => ['key' => 'value',],
        ]);
        ModelException::saveOrThrow($lead);

        $conversionId = 1;
        $this->service->register($lead, $conversionId);
        $this->assertArraySubset(
            [
                'Response for conversion 1 does not formed well.',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            $this->logger->messages[count($this->logger->messages) - 11]
        );
        $this->assertArraySubset(
            [
                'Conversion 1 sent.',
                2 => Cpa\Conversion\Sync\Service::class,
            ],
            $this->logger->messages[count($this->logger->messages) - 10]
        );

        $savedConversion = Cpa\Conversion::find()
            ->andWhere(['=', 'user_lead_id', $lead->id])
            ->andWhere(['=', 'conversion_id', (string)$conversionId])
            ->one();

        $this->assertInstanceOf(Cpa\Conversion::class, $savedConversion);

        $this->assertNull(
            $savedConversion->response
        );
    }
}
