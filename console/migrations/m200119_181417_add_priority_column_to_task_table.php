<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task}}`.
 */
class m200119_181417_add_priority_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'priority_id', $this->integer());
        $this->addColumn('task', 'is_template', $this->boolean());

        $this->addForeignKey('fk-task-creator_id', 'task', 'creator_id', 'user', 'id');
        $this->addForeignKey('fk-task-performer_id', 'task', 'performer_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task', 'priority_id');
        $this->dropColumn('task', 'is_template');

        $this->dropForeignKey('fk-task-creator_id', 'task');
        $this->dropForeignKey('fk-task-performer_id', 'task');
    }
}
