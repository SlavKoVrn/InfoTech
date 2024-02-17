<?php
namespace common\helpers;

use Yii;
use yii\db\Query;

class Helper
{
    static function asDate($v) {
        return date('d.m.Y H:i:s', $v);
    }

    static function humanPhone($phone)
    {
        return '+7('
            .substr($phone,0,3).')'
            .substr($phone,3,3).'-'
            .substr($phone,6,2).'-'
            .substr($phone,8,2);
    }

    static function findAuthorsBySubstring($q)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id, fio AS text')
                ->from('authors')
                ->where(['like', 'fio', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    static function findBooksBySubstring($q)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id, CONCAT_WS(" " ,`isbn`,`name`,`release_year`) AS text')
                ->from('books')
                ->where(['like', 'isbn', $q])
                ->orWhere(['like', 'name', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }
}
