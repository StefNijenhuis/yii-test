<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170214_103434_create_activity_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('activity', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'category' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-activity-user_id',
            'activity',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-activity-user_id',
            'activity',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-activity-user_id',
            'activity'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-activity-user_id',
            'activity'
        );

        $this->dropTable('activity');
    }
}
