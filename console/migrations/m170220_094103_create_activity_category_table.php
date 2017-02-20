<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity_category`.
 */
class m170220_094103_create_activity_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('activity_category', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('activity_category');
    }
}
