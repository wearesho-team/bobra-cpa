<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use Wearesho\Bobra\Cpa\Records\UserLead;

/**
 * Class UserLeadMock
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Mocks
 */
class UserLeadMock extends UserLead
{
    const SOURCE_TEST = 'test';

    public static function tableName()
    {
        return 'user_lead';
    }
}
