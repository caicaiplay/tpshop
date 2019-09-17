<?php

namespace app\admin\controller;

class System extends Base
{
    // 设置标题 版本
    public function set()
    {
        $info = model('System')->find();
        $viewInfo = [
            'system' => $info,
        ];
        $this->assign($viewInfo);
        if (request()->isAjax()) {
            $data = [
                'webname' => input('post.webname'),
                'copyright' => input('post.copyright'),
                'id' => input('post.id')
            ];
            $result = model('System')->set($data);
            if ($result == 1) {
                $this->success('设置成功','admin/home/index');
            } else {
                $this->error($result);
            }
        }
        return view();
    }
}
