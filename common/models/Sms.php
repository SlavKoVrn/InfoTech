<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property int|null $subscriber_id
 * @property string|null $status
 * @property string|null $phone
 * @property string|null $text
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Sms extends \yii\db\ActiveRecord
{
    const STATUS_SEND = 'send';
    const STATUS_NOT_SEND = 'not_send';
    const STATUS_ERROR = 'error';

    public $statuses = [
        self::STATUS_SEND => 'Доставлено',
        self::STATUS_NOT_SEND => 'К Доставке',
        self::STATUS_ERROR => 'Ошибка',
    ];

    public static function getStatusesArray()
    {
        return [
            self::STATUS_SEND => 'Доставлено',
            self::STATUS_NOT_SEND => 'К Доставке',
            self::STATUS_ERROR => 'Ошибка',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscriber_id'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 10],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'subscriber_id' => 'Подписчик',
            'status' => 'Статус',
            'phone' => 'Телефон',
            'text' => 'Текст',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * Gets query for [[Subscriber]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(Subscriber::class, ['id' => 'subscriber_id']);
    }

}
