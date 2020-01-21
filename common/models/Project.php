<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int|null $creator_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $priority_id
 * @property int|null $status
 * @property int|null $parent_project_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $creator
 * @property Project $parentProject
 * @property Project[] $projects
 * @property Priority $priority
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_IN_PROGRESS = 20;
    const STATUS_DONE = 30;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_id', 'priority_id', 'status', 'parent_project_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['creator_id', 'default', 'value' => Yii::$app->user->identity->id],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => [
                static::STATUS_ACTIVE,
                static::STATUS_IN_PROGRESS,
                static::STATUS_DONE
            ]],
            [['parent_project_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Project::class,
                'targetAttribute' => ['parent_project_id' => 'id']
            ],
            [['priority_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Priority::class,
                'targetAttribute' => ['priority_id' => 'id']
            ],
        ];
    }

    public function behaviors()
    {
        return [
          TimestampBehavior::class => [
              'class' => TimestampBehavior::class
          ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'title' => 'Title',
            'description' => 'Description',
            'priority_id' => 'Priority ID',
            'status' => 'Status',
            'parent_project_id' => 'Parent Project ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentProject()
    {
        return $this->hasOne(Project::class, ['id' => 'parent_project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['parent_project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id'])->where(['type' => Priority::TYPE_PROJECT]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

    public function getStatusTitle()
    {
        return [
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_IN_PROGRESS => 'In progress',
            static::STATUS_DONE => 'Done',
        ];
    }
}
