<?php


namespace app\common\validate;


use think\Validate;

class Cate extends Validate
{
    protected $rule = [
        'catename|栏目名' => 'require|max:25|chsDash|unique:cate',
        'sort|排序号'     => 'require|number',
    ];

    // 添加模块验证
    public function sceneAdd()
    {
        return $this->only(['catename','sort']);
    }

    // 排序验证
    public function sceneSort()
    {
        return $this->only(['sort']);
    }

    // 编辑验证
    public function sceneUpdate()
    {
        return $this->only(['catename']);
    }
}