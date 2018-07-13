<?php

namespace Wearesho\Bobra\Cpa\Migrations;

use yii\db\Migration;

/**
 * Class M180220122155CreateConverionTable
 */
class M180220122155CreateConversionTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            'user_lead_conversion',
            [
                'id' => $this->primaryKey(),
                'user_lead_id' => $this->integer()->notNull(),
                'conversion_id' => $this->text()->notNull(),
                'request' => 'JSON NOT NULL',
                'response' => 'JSON',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user_lead_conversion');
    }
}
