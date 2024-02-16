<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['name', 'phone'], 'required'],
            [['phone'], 'filter', 'filter' => function($value) {
                return str_replace(['+7(',')','-'],'',$value);
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Имя',
            'phone' => 'Телефон',
        ];
    }

    public function getHumanPhone()
    {
        return '+7('
            .substr($this->phone,0,3).')'
            .substr($this->phone,3,3).'-'
            .substr($this->phone,6,2).'-'
            .substr($this->phone,8,2);
    }
}
