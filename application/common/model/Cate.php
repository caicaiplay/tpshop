<?php

namespace app\common\model;

use think\Model;
use app\facade\Cate as Vcate;
//use think\Db;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    protected $pk = 'id';
    protected $table = 'tp_cate';
    use SoftDelete; // 软删除

    //关联模型
    public function article()
    {
        return $this->hasMany('Article', 'cate_id', 'id');
    }

    // 添加模块
    public function add($data)
    {
        if (!Vcate::scene('add')->check($data)) {
            return Vcate::getError();
        }
        return $this->allowField(true)->save($data);
    }

    //栏目排序
    public function sort($data)
    {
        if (!Vcate::scene('sort')->check($data)) {
            return Vcate::getError();
        }
        $sortInfo = $this->find($data['id']);
        $sortInfo->sort = $data['sort'];
        $result = $sortInfo->save();
        if ($result == 1) {
            return 1;
        } else {
            return '排序失败';
        }
    }

    // 栏目编辑
    public function updateCate($data)
    {
        if (!Vcate::scene('Update')->check($data))  {
            return Vcate::getError();
        }
        $cateInfo = $this->find($data['id']);
        $cateInfo->catename = $data['catename'];
        $result = $cateInfo->save();
        if ($result == 1) {
            return 1;
        } else {
            return '编辑失败';
        }
    }
}
