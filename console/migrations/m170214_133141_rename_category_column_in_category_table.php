<?php

use yii\db\Migration;

class m170214_133141_rename_category_column_in_category_table extends Migration
{
    public function up()
    {
        $this->renameColumn('category', 'category', 'title');
    }

    public function down()
    {
        $this->renameColumn('category', 'title', 'category');
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
