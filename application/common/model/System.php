<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class System extends Model
{
    // 软删除
    use SoftDelete;

    // 设置版权信息
    public function set($data)
    {
        $validate = new \app\common\validate\System;
        if (!$validate->check($data)) {
            return $validate->getError();
        }
        $reset = $this->find($data['id']);
        $reset->webname = $data['webname'];
        $reset->copyright = $data['copyright'];
        $result = $reset->save();
        if ($result) {
            return 1;
        } else {
            return '修改失败!';
        }
    }

}
