<?php


namespace app\facade;

use think\Facade;

class Article extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\validate\Article';
    }
}