<?php

namespace frontend\models;

use common\models\User;
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
 *
 * @property User $performer
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DONE = 20;

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
            [['title', 'performer_id', 'description'], 'required'],
            [['status', 'creator_id', 'performer_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [
                self::STATUS_ACTIVE, self::STATUS_DONE
            ]],
            ['creator_id', 'default', 'value' => Yii::$app->user->id],
            ['performer_id', 'exist', 'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['performer_id' => 'id']
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
}
