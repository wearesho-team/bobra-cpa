<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use yii\web\IdentityInterface;

class UserMock implements IdentityInterface
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function findIdentity($id)
    {
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }
}
