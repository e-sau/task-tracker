<?php

use yii\db\Migration;

/**
 * Class m200119_183647_create_fk_task_to_priority
 */
class m200119_183647_create_fk_task_to_priority extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-task-priority_id', 'task', 'priority_id', 'priority', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-priority_id', 'task');
    }
}
