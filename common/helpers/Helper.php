<?php
namespace common\helpers;

use Yii;

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

}
