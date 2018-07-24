<?php

namespace Wearesho\Bobra\Cpa\Migrations;

use yii\db\Migration;

/**
 * Class M180720152215AddProductColumnToUserLeadTable
 */
class M180720152215AddProductColumnToUserLeadTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn(
            'user_lead',
            'product',
            $this->string(64)->null()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn(
            'user_lead',
            'product'
        );
    }
}
