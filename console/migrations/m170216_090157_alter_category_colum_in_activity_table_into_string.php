<?php

use yii\db\Migration;

class m170216_090157_alter_category_colum_in_activity_table_into_string extends Migration
{
    public function up()
    {
        $this->alterColumn('activity', 'category', $this->string()->notNull());
    }

    public function down()
    {
        $this->alterColumn('activity', 'category', $this->text()->notNull());
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
