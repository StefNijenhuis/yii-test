<?php

use yii\db\Migration;

class m170215_134654_change_name_of_imagefile_into_image extends Migration
{
    public function up()
    {
        $this->renameColumn('activity', 'imageFile', 'image');
    }

    public function down()
    {
        $this->renameColumn('activity', 'image', 'imageFile');
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
