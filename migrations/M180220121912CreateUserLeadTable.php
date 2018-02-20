<?php

namespace Wearesho\Bobra\Cpa\Migrations;

use yii\db\Migration;

/**
 * Class M180220121912CreateUserLeadTable
 */
class M180220121912CreateUserLeadTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            'user_lead',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'source' => $this->text()->notNull(),
                'config' => 'JSON NOT NULL',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user_lead');
    }
}
