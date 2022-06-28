<?php
declare (strict_types = 1);

namespace app;

use liliuwei\think\Jump;
use think\App;
use think\exception\ValidateException;
use think\Validate;
use think\facade\Db;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
/**
 * 控制器基础类
 */
abstract class BaseController
{

    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {

        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    //文件上传
    public function up_file($arr = array())
    {
        if (is_uploaded_file($_FILES[$arr['name']]['tmp_name'])) {
            $upfile = $_FILES[$arr['name']];
            $name = $upfile["name"];
            $type = $upfile["type"];
            $size = $upfile["size"];
            $tmp_name = $upfile["tmp_name"];
            $error = $upfile["error"];
            if($error=='0')
            {
                $suffix=substr($name, strrpos($name, ".")+1);
                $img_name=time().'_'.$arr['name'].'.'.$suffix;
                $save_path = 'Uploads/images/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
                if (!file_exists($save_path)) {
                    mkdir($save_path, 0777, true);//创建文件
                }
                $file_path = $save_path . $img_name;
                move_uploaded_file($tmp_name,$file_path);
            }
        }
        return $file_path;
    }

    //递归分类
    public function sort($data,$pid =0,$level = 0){
        //定义一个静态数组
        static $arr  = [];
        foreach($data  as $v){
            if ($pid == $v['classify_pid']){
                $v['level_id']=$level;
                $arr[] =  $v;
                $this->sort($data,$v['classify_id'],$level+1);
            }
        }
        //获得一级id
        return $arr;
    }

    //表单显示--添加页面
    public function input_add($arr){
        foreach ($arr as &$v){
            switch ($v['input_type_id']){
                case 3:
                    $v['site'] = 'editor'.mt_rand(100000,999999);
                    break;
                case 4:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
                case 5:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
                case 6:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
            }
        }
        return $arr;
    }

    //表单显示--修改页面
    public function input_edit($arr,$content){
        foreach ($arr as &$v){
            switch ($v['input_type_id']){
//                case 1:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
//                case 2:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
                case 3:
                    $v['site'] = 'editor'.mt_rand(100000,999999);
                    break;
                case 4:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    if(!empty($content[$v['field_name']])){
                        $v['site'] = @unserialize($content[$v['field_name']]);
                    }
                    break;
                case 5:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
//                    $v['site'] = $site[$v['field_name']];
                    break;
                case 6:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
//                    $v['site'] = $site[$v['field_name']];
                    break;
//                case 7:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
//                case 8:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
//                case 9:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
//                case 10:
//                    $v['site'] = $site[$v['field_name']];
//                    break;
            }
        }
        return $arr;
    }

    /*
     * 导出
     * 样式修改
     * $preadsheet->getActiveSheet()->getDefaultStyle()->getFont()->setSize(12);//字体大小
     * $preadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(false);//是否加粗
     * $preadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);//是是否加粗
     * $preadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);//第一行字体大小
     * $preadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(20);//设置默认行高
     * $preadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);//设置第一行行高
     * $preadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);//设置第一列宽度
     * $preadsheet->getActiveSheet()->mergeCells("A1:F1");//合并
     * $preadsheet->getActiveSheet()->setCellValue("内容");//插入数据
     * $preadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);//加粗
     * 合并实例
     * $preadsheet->getActiveSheet()->mergeCells('A1:F1');
     * $preadsheet->getActiveSheet()->mergeCells('A2:F2');
     * $preadsheet->getActiveSheet()->mergeCells('A6:F6');
     * $preadsheet->getActiveSheet()->mergeCells('A11:B11');
     * 设置垂直居中
     * $preadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
     * $preadsheet->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
     * 设置水平居中
     * $preadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
     * $preadsheet->getActiveSheet()->getStyle('A1:F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
     * 设置左对齐
     * $preadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
     * 设置sheet页签名称
     * $preadsheet->getActiveSheet()->setTitle('数据统计-1');
    */
    public static function export($header = [], $type = true, $data = [], $fieldName = [],$fileName = "1910")
    {

        // 实例化类
        $preadsheet = new Spreadsheet();
        // 创建sheet
        $sheet = $preadsheet->getActiveSheet();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        // 循环设置表头数据
        foreach ($header as $k => $v) {
            $sheet->setCellValue($cellName[$k].'1', $v);
        }

        // 生成数据--初始
        //$sheet->fromArray($data, null, "A2");
        foreach ($data as $key=>$val){
            //设置第N行高度
            $preadsheet->getActiveSheet()->getRowDimension($key+2)->setRowHeight(30);

            foreach ($val as $k=>$v) {
                //设置第N列宽度
                $preadsheet->getActiveSheet()->getColumnDimension($cellName[$k])->setWidth(30);
                $input_type_id = Db::name('input')->where('input_id=' . $fieldName[$k]['input_id'])->value('input_type_id');

                if($input_type_id==4){
                    $str = '';
                    $strArr = unserialize($v);
                    $arr = Db::name('input')->where(array('input_pid'=>$fieldName[$k]))->field('input_name,input_value')->select()->toArray();
                    foreach ($arr as $vi){
                        if(in_array($vi['input_value'],$strArr)){
                            $str.= $vi['input_name'].',';
                        }
                    };
                    $str = trim($str,',');
                    $sheet->setCellValue($cellName[$k].($key+2),$str );
                }else if($input_type_id==5||$input_type_id==6){ //单选框、下拉框
                    $str = Db::name('input')->where(array('input_pid'=>$fieldName[$k],'input_value'=>$v))->value('input_name');
                    $sheet->setCellValue($cellName[$k].($key+2),$str );
                }else if($input_type_id==7&&!empty($v)){ //上传口
                    $thumb = str_replace(request()->domain(), '.', $v);
                    $drawing[$key] = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
//                    $drawing[$key]->setName('图片');
//                    $drawing[$key]->setDescription('图片');
                    $drawing[$key]->setPath($v);
//                    $drawing[$key]->setWidth(80);
                    $drawing[$key]->setHeight(80);
                    $drawing[$key]->setCoordinates($cellName[$k].($key+2));
                    $drawing[$key]->setOffsetX(20);
                    $drawing[$key]->setOffsetY(20);
                    $drawing[$key]->setWorksheet($preadsheet->getActiveSheet());
                    $preadsheet->getActiveSheet()->getRowDimension($key+2)->setRowHeight(80);
                }else if($input_type_id==8&&!empty($v)){ //日期框
                    $sheet-> setCellValue($cellName[$k].($key+2),date('Y-m-d H:i:s',$v));
                }else{
                    $sheet->setCellValue($cellName[$k].($key+2), $v);
                }
                //$sheet-> setCellValue($cellName[$kay].($k+2),$v);
            }
        }

        // 样式设置--初始
        //$sheet->getDefaultColumnDimension()->setWidth(12);
        // 设置下载与后缀
        if ($type) {
            header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            $type = "Xlsx";
            $suffix = "xlsx";
        } else {
            header("Content-Type:application/vnd.ms-excel");
            $type = "Xls";
            $suffix = "xls";
        }
        ob_end_clean();//清楚缓存区
        // 激活浏览器窗口
        header("Content-Disposition:attachment;filename=$fileName.$suffix");
        //缓存控制
        header("Cache-Control:max-age=0");
        // 调用方法执行下载
        $writer = IOFactory::createWriter($preadsheet, $type);
        // 数据流
        $writer->save("php://output");
    }

    //文件导入上传
    public function export_file($arr = array())
    {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $upfile = $_FILES['file'];
            $name = $upfile["name"];
            $type = $upfile["type"];
            $size = $upfile["size"];
            $tmp_name = $upfile["tmp_name"];
            $error = $upfile["error"];
            if($error=='0')
            {
                $suffix=substr($name, strrpos($name, ".")+1);
                $img_name=date('YmdHis').'_file.'.$suffix;
                $save_path = 'Uploads/exportfile/';
                if (!file_exists($save_path)) {
                    mkdir($save_path, 0777, true);//创建文件
                }
                $file_path = $save_path . $img_name;
                move_uploaded_file($tmp_name,$file_path);
            }
        }
        return $file_path;
    }
    // excel导入
    public static function importExcel($filename = "")
    {
        if (file_exists($filename)) { //检查文件是否存在
            $exts = pathinfo($filename, PATHINFO_EXTENSION);  //文件类型
            // 有Xls和Xlsx格式两种
            if ($exts == 'xlsx') {
                $objReader = IOFactory::createReader('Xlsx');
            } else {
                //$objReader = IOFactory::createReader('Xls');
                $info = "请使用'Xlsx'格式文件进行带图片上传,否则图片上传失败！";
                $arr['code'] = 300;
                $arr['msg'] = $info;
                return $arr;
                die();
            }

            $imageFilePath = 'Uploads/images/'.date('Y').'/'.date('m').'/'.date('d').'/';//图片保存目录
            if (!file_exists($imageFilePath)) {
                mkdir("$imageFilePath", 0777, true);
            }

            $objSpreadsheet = IOFactory::load($filename);
            $objWorksheet = $objSpreadsheet->getActiveSheet(0);  //getSheet(0)
            $highestRow = $objWorksheet->getHighestRow(); // 取得总行数
            $data = $objWorksheet->toArray();
            //$drawing 为 PhpOffice\PhpSpreadsheet\Worksheet\Drawing类的实例;   仅仅支持xlsx格式文件
            foreach ($objWorksheet->getDrawingCollection() as $drawing) {
                list($startColumn, $startRow) = Coordinate::coordinateFromString($drawing->getCoordinates());
                //$imageFileName = $drawing->getIndexedFilename(); //获取文件名称
                $imageFileName = date('YmdHis').mt_rand(1000,9999);

                switch ($drawing->getMimeType()) {
                    case 'image/jpg':
                    case 'image/jpeg':
                        $imageFileName .= '.jpg';
                        imagejpeg($drawing->getImageResource(),$imageFilePath.$imageFileName);
                        break;
                    case 'image/gif':
                        $imageFileName .= '.gif';
                        imagegif($drawing->getImageResource(),$imageFilePath.$imageFileName);
                        break;
                    case 'image/png':
                        $imageFileName .= '.png';
                        imagepng($drawing->getImageResource(),$imageFilePath.$imageFileName);
                        break;
                }
//                switch ($drawing->getExtension()) {
//                    case 'jpg':
//                    case 'jpeg':
//                        $imageFileName .= '.jpg';
//                        $source = imagecreatefromjpeg($drawing->getPath());
//                        imagejpeg($source, $imageFilePath . $imageFileName);
//                        break;
//                    case 'gif':
//                        $imageFileName .= '.gif';
//                        $source = imagecreatefromgif($drawing->getPath());
//                        imagegif($source, $imageFilePath . $imageFileName);
//                        break;
//                    case 'png':
//                        $imageFileName .= '.png';
//                        $source = imagecreatefrompng($drawing->getPath());
//                        imagepng($source, $imageFilePath . $imageFileName);
//                        break;
//                }
                $startColumn = ABC2decimal($startColumn);
                $data[$startRow - 1][$startColumn] = $imageFilePath . $imageFileName;
            }
            array_shift($data);
            $arr['code'] = 200;
            $arr['msg'] = $data;
            return $arr;
            die();
            /*
            //从第二行开始
            for ($i = 1; $i <= $highestRow - 1; $i++) {
                $add_data[$i]['goods_name'] = $data[$i][0];
                $add_data[$i]['image'] = $data[$i][1];
            }
            //$success_count = Db::name('test')->insertAll($add_data);
            //unlink($filePath);  //删除文件
            //判断导入成功数量
            if ($success_count == $highestRow - 1) {
                $info = '导入成功！本次成功导入数量：' . $success_count . '条';
                $arr['code'] = 200;
                $arr['msg'] = $info;
                echo json_encode($arr);
                die();
            } else {
                $info = '导入成功！本次成功导入字段数量：' . $success_count . '条,无效数据或已重复上传' . ($highestRow - 1) - $success_count . '条,与目标数不符！';
                $arr['code'] = 200;
                $arr['msg'] = $info;
                echo json_encode($arr);
                die();
            }
            */
        } else {
            $info = "文件不存在,文件上传失败！";
            $arr['code'] = 300;
            $arr['msg'] = $info;
            echo json_encode($arr);
            die();
        }
        //简单模式
        /*
        $spreadsheet = IOFactory::load($filename);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        array_shift($sheetData);
        */

    }







    use \liliuwei\think\Jump;
}
