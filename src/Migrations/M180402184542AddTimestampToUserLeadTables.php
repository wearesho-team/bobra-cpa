<?php

namespace Wearesho\Bobra\Cpa\Migrations;

use Carbon\Carbon;
use yii\db\Migration;

/**
 * Class M180402184542AddTimestampToUserLeadTables
 */
class M180402184542AddTimestampToUserLeadTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (['user_lead', 'user_lead_conversion'] as $tableName) {
            if ($this->db->schema instanceof \yii\db\pgsql\Schema) {
                // PostgreSQL does really support `not null` for timestamps

                $this->addColumn(
                    $tableName,
                    'created_at',
                    'TIMESTAMP NULL DEFAULT NULL'
                );
                $this->execute("UPDATE $tableName SET created_at=:now;", ['now' => Carbon::now()->toDateTimeString()]);
                $this->execute(/** @lang PostgreSQL */
                    "ALTER TABLE $tableName ALTER COLUMN created_at SET NOT NULL"
                );
            } else {
                // MySQL does not support not null timestamp, we need to set default expression instead

                $this->addColumn(
                    $tableName,
                    'created_at',
                    $this->timestamp()->notNull()->defaultExpression('now()')
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach (['user_lead_conversion', 'user_lead'] as $tableName) {
            $this->dropColumn($tableName, 'created_at');
        }
    }
}
