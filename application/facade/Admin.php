<?php


namespace app\facade;

use think\Facade;
class Admin extends Facade
{
    protected static function getFacadeClass()
    {
        return 'app\common\validate\Admin';
    }
}
