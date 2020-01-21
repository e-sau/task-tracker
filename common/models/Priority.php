<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "priority".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $order
 * @property int|null $type
 *
 * @property Task[] $tasks
 */
class Priority extends \yii\db\ActiveRecord
{
    const TYPE_PROJECT = 1;
    const TYPE_TASK = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title', 'order'], 'string', 'max' => 255],
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
            'order' => 'Order',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['priority_id' => 'id']);
    }
}
