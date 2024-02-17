<?php

namespace common\models;

use common\helpers\Helper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subscriber".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 */
class Subscriber extends \yii\db\ActiveRecord
{
    public $authors;

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
            [['name', 'phone', 'authors'], 'required'],
            [['phone'], 'filter', 'filter' => function ($value) {
                return str_replace(['+7(', ')', '-'], '', $value);
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
            'authors' => 'Авторы',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->authors = $this->getAuthorIds();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->authorsSave($this->authors);
    }

    public function getCurrentAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable(SubscriberAuthor::tableName(), ['subscriber_id' => 'id']);
    }

    public function getAuthorIds()
    {
        return ArrayHelper::map($this->currentAuthors, 'id', 'id');
    }

    public function getAuthorkNames()
    {
        return ArrayHelper::map($this->currentAuthors, 'id', 'fio');
    }

    public function authorsSave($newAuthorIds)
    {
        $currentAuthorIds = $this->authorIds;
        $toInsert = [];
        foreach (array_filter(array_diff($newAuthorIds, $currentAuthorIds)) as $author_id) {
            $toInsert[] = $author_id;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($toInsert) {
                foreach ($toInsert as $author_id) {
                    $subscriberAuthor = new SubscriberAuthor;
                    $subscriberAuthor->setAttributes([
                        'subscriber_id' => $this->id,
                        'author_id' => $author_id,
                    ]);
                    $subscriberAuthor->save();
                }
            }
            if ($toRemove = array_filter(array_diff($currentAuthorIds, $newAuthorIds))) {
                SubscriberAuthor::deleteAll([
                    'subscriber_id' => $this->id,
                    'author_id' => $toRemove
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
    }

    public function subscribeMessage()
    {
        $authors = $this->getAuthorkNames();
        return Helper::humanPhone($this->phone).' '.$this->name.'<br/>Подписка зарегистрирована на авторов <br/>'.
            implode('<br/>',$authors);
    }
}
