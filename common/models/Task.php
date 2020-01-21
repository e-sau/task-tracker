<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property int|null $status
 * @property string|null $description
 * @property int|null $creator_id
 * @property int|null $performer_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $priority_id
 * @property bool $is_template
 * @property int|null $template_id
 *
 * @property User $performer
 * @property Task $template
 * @property Priority $priority
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_IN_PROGRESS = 20;
    const STATUS_DONE = 30;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'performer_id', 'description', 'priority_id'], 'required'],
            [['creator_id', 'performer_id', 'created_at', 'updated_at', 'template_id'], 'integer'],
            [['description'], 'string'],
            [['is_template'], 'boolean'],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => [
                static::STATUS_ACTIVE,
                static::STATUS_IN_PROGRESS,
                static::STATUS_DONE
            ]],
            ['creator_id', 'default', 'value' => Yii::$app->user->id],
            ['performer_id', 'exist', 'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['performer_id' => 'id']
            ],
            ['priority_id', 'exist', 'skipOnError' => false,
                'targetClass' => Priority::class,
                'targetAttribute' => ['priority_id' => 'id']
            ],
            ['template_id', 'exist', 'skipOnError' => true,
                'targetClass' => Task::class,
                'targetAttribute' => ['template_id' => 'id']
            ],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'status' => 'Status',
            'description' => 'Description',
            'creator_id' => 'Creator ID',
            'performer_id' => 'Performer ID',
            'priority' => 'Priority',
            'is_template' => 'Is template?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    public function getPerformer()
    {
        return $this->hasOne(User::class, ['id' => 'performer_id']);
    }

    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id']);
    }

    public function getTemplate()
    {
        return $this->hasOne(Task::class, ['id' => 'template_id']);
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
