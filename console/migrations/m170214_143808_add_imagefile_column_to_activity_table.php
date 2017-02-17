<?php

use yii\db\Migration;

/**
 * Handles adding imagefile to table `activity`.
 */
class m170214_143808_add_imagefile_column_to_activity_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('activity', 'imageFile', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('activity', 'imageFile');
    }
}
