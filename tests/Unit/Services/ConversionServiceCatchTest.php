<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 21.02.18
 * Time: 13:27
 */

namespace Wearesho\Bobra\Cpa\Tests\Unit\Services;


use Horat1us\Yii\Exceptions\ModelException;
use paulzi\jsonBehavior\JsonField;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Bobra\Cpa\Records\UserLeadConversion;
use Wearesho\Bobra\Cpa\Services\ConversionService;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\UserMock;

class ConversionServiceCatchTest extends AbstractTestCase
{
    /** @var int */
    protected $lastConversionId;

    protected function setUp()
    {
        parent::setUp();

        \Yii::$app->user->setIdentity(new UserMock(mt_rand(1, 1000)));
        $lastConversion = UserLeadConversion::find()
            ->orderBy('id DESC')
            ->one();

        $this->lastConversionId = $lastConversion instanceof UserLeadConversion
            ? $lastConversion->id
            : 0;
    }

    public function testWithoutIdentity()
    {
        \Yii::$app->user->setIdentity(null);
        ConversionService::catchEvent();

        $this->assertFalse(
            UserLeadConversion::find()
                ->andWhere(['>', 'id', $this->lastConversionId,])
                ->exists()
        );
    }

    public function testWithoutLead()
    {
        ConversionService::catchEvent();

        $this->assertFalse(
            UserLeadConversion::find()
                ->andWhere(['>', 'id', $this->lastConversionId,])
                ->exists()
        );
    }

    /**
     * @throws \Horat1us\Yii\Traits\ModelExceptionTrait
     */
    public function testCorrectCatching()
    {
        $lead = new UserLead();
        $lead->user_id = \Yii::$app->user->id;
        $lead->source = Userlead::SOURCE_SALES_DOUBLER;
        $lead->config = new JsonField([
            'test' => 'test',
        ]);

        ModelException::saveOrThrow($lead);

        ConversionService::catchEvent();

        $this->assertTrue(
            UserLeadConversion::find()
                ->andWhere(['=', 'user_lead_id', $lead->id,])
                ->andWhere(['>', 'id', $this->lastConversionId,])
                ->exists()
        );
    }
}