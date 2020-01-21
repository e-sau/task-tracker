<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m200121_183931_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'creator_id' => $this->integer(),
            'title' => $this->string(),
            'description' => $this->text(),
            'priority_id' => $this->integer(),
            'status' => $this->integer(),
            'parent_project_id' => $this->integer(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
        ]);

        $this->addForeignKey(
            'fk-project-creator_id',
            'project',
            'creator_id',
            'user',
            'id'
        );
        $this->addForeignKey(
            'fk-project-priority_id',
            'project',
            'priority_id',
            'priority',
            'id'
        );
        $this->addForeignKey(
            'fk-project-parent_project_id',
            'project',
            'parent_project_id',
            'project',
            'id'
        );

        $this->addColumn('task', 'project_id', $this->integer());
        $this->addForeignKey(
            'fk-task-project_id',
            'task',
            'project_id',
            'project',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-project_id', 'task');
        $this->dropColumn('task', 'project_id' );
        $this->dropForeignKey('fk-project-creator_id', 'project');
        $this->dropForeignKey('fk-project-priority_id', 'project');
        $this->dropForeignKey('fk-project-parent_project_id', 'project');
        $this->dropTable('{{%project}}');
    }
}
