<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task}}`.
 */
class m200119_184317_add_template_id_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'template_id', $this->integer());
        $this->addForeignKey('fk-task-template_id', 'task', 'template_id', 'task', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-template_id', 'task');
        $this->dropColumn('task', 'template_id');
    }
}
