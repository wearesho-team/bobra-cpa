<?php

namespace Horat1us\Package\Tests\Fixtures;

use Horat1us\Package\Records\ExampleRecord;
use yii\base\Security;
use yii\test\ActiveFixture;

/**
 * Class ExampleRecordFixture
 * @package Horat1us\Package\Tests\Fixtures
 *
 * @internal
 */
class ExampleRecordFixture extends ActiveFixture
{
    public $modelClass = ExampleRecord::class;

    /** @var Security */
    protected $security;

    public function __construct(Security $security, array $config = [])
    {
        parent::__construct($config);
        $this->security = $security;
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    protected function getData()
    {
        return [
            ['text' => $this->security->generateRandomString()],
            ['text' => $this->security->generateRandomString()],
        ];
    }
}
