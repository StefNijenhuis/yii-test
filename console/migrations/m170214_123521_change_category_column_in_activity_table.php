<?php

use yii\db\Migration;

class m170214_123521_change_category_column_in_activity_table extends Migration
{
    public function up()
    {
        $this->alterColumn('activity', 'category', $this->text()->notNull());
    }

    public function down()
    {
        $this->alterColumn('activity', 'category', $this->integer()->notNull());
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
