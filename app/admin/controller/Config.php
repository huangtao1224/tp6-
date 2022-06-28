<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Config extends BaseController
{
    public function index()
    {
        $input = Db::name('input')->where([['type_id','=',4],['edit_switch','=',2],['input_pid','=',null]])->order('date','asc')->select()->toArray();
        $functionSwitch = Db::name('function_switch')->where('version_id=1')->find();
//        $input = $this->input_edit($input,$functionSwitch);

        return view('',[
            'functionSwitch'=>$functionSwitch,
            'input'=>$input,
        ]);
    }


    //功能启用、禁用
    public function show_hide(){
        $input_id = pg('id');
        $input = Db::name('input')->where('input_id='.$input_id)->value('field_name');
        $data[$input] = pg('show_id');
        $data['function_switch_id'] = 1;
        $res = Db::name('function_switch')->save($data);
        echo $res;
    }
}