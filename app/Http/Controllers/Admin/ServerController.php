<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ImportRepository;

class ServerController extends Controller
{
    //私有属性
    protected $importRepository;

    //构造函数 
    public function __construct(ImportRepository $importRepository)
    {
       $this->importRepository = $importRepository;
    }
   
    //导入csv
    public function import()
    {
    	$rs = $this->checkfiles($_FILES);
    	if($rs['code'] == 0){
    		return ['code'=>0,'error'=>$rs['error']];
    	}
    	//拼接服务器上面的图片存放位置
    	$file_path = './download/export.' . $rs['error'];
    	if(!move_uploaded_file($_FILES['file']['tmp_name'],$file_path)){
    		return ['code'=>0,'上传失败!'];
    	};
    	$this->csvDataInsertToDB($file_path);
    	//移动到指定的服务器位置
    	return ['code'=>1];
    }

    //导入数据
    public function csvDataInsertToDB($file_path)
    {
    	ini_set('memory_limit','1024M');	//设置缓存
    	set_time_limit(0);	//执行脚本不限制时间
    	ignore_user_abort(true);	//游览器断开继续执行

    	$handle = fopen($file_path,'rb');
    	//将文件一次性保存到数组
    	$excelData = array();
    	while ($row = fgetcsv($handle,1000,',')) {
    		$excelData[] = $row;
    	}
    	//数组的总长度
    	$total = count($excelData);
    	if($total > 50000){
    		return ['code'=>0,'error'=>'数据不得超出5万'];
    	}
    	$chunkData = array_chunk($excelData, 5000);

    	$now = date('Y-m-d H:i:s',time());
        $order_li = 'i' . time();
        //dd($order_li);
    	$count = count($chunkData);
    	for ($i=0; $i < $count; $i++) { 
    		foreach ($chunkData[$i] as $v) {
    			$nikename = mb_convert_encoding($v[0],'utf-8','gbk');
    			$realname = mb_convert_encoding($v[1],'utf-8','gbk');
    			$tel = mb_convert_encoding($v[2],'utf-8','gbk');
    			$pingtai = mb_convert_encoding($v[3],'utf-8','gbk');
    			$regtime = mb_convert_encoding($v[4],'utf-8','gbk');
    			$loginlasttime = mb_convert_encoding($v[5],'utf-8','gbk');
    			$daili = mb_convert_encoding($v[6],'utf-8','gbk');
    			$http = mb_convert_encoding($v[7],'utf-8','gbk');
    			$c_money = mb_convert_encoding($v[8],'utf-8','gbk');
    			$t_money = mb_convert_encoding($v[9],'utf-8','gbk');
    			$str = "('{$nikename}','{$realname}','{$tel}','{$pingtai}','{$regtime}','{$loginlasttime}','{$daili}','{$http}','{$c_money}','{$t_money}','{$now}','{$order_li}')";
    			$values[] = $str;
    		}
    		//5000个数据之后插入数据库
    		$data = implode(',', $values);
    		DB::insert(" INSERT IGNORE INTO df_client (`nikename`,`realname`,`tel`,`pingtai`,`regtime`,`loginlasttime`,`daili`,`http`,`c_money`,`t_money`,`created_at`,`order_li`) VALUES {$data}");
    	}

    	//导入批次
    	DB::table('import')->insert(['order_li'=>$order_li,'mg_id'=>get_mg_id(),'count'=>$total,'created_at'=>$now]);
    	return ['code'=>1];
    }

    //上传文件检验
    public function checkfiles($f)
    {
    	//文件的后缀名
    	$ext = explode('.', $f['file']['name']);
    	if($ext[1] != 'csv'){
    		return ['code'=>0,'error'=>'上传的文件格式不对,请上传CSV'];
    	};
    	//文件大小限制
    	if($f['file']['size'] > 80*1024*1024){
    		return ['code'=>0,'error'=>'上传文件过大,不可上传'];
    	}
    	return ['code'=>1,'error'=>$ext[1]];	
    }

    //数据回滚(物理)
    public function rollback(Request $request)
    {
        $z = $this->importRepository->deleteClientByorderLi($request->get('order_li'));

        return $z ? ['code'=>1] :['code'=>0,'error'=>'这个单号没有数据'];
    }

    //数据导出
    public function show(Request $request)
    {
        $data =  DB::table('export')->paginate(11);
        $manager = $this->importRepository->getManager_name_id();

        return view('admin.work.export',compact('data','manager'));
    }

    //数据导出操作
    public function export(Request $request)
    {
        //获取到需要的数据
        $data = $this->importRepository->getExportData($request->get('range'));
        $head = ['id','title','content','time','username','name','pingtai','mg'];
        $this->putCsv('./download/export.csv',$data,$head);
        $res['data'] = route('download', ['file' => 'export']);
        
        return $res;
    }

    //实现写入数组文件
    public function putCsv($filename,$data,$head='')
    {
       $handle = fopen($filename,'w'); //写入的方式打开
        //写入表头
        if(!empty($head)){
            foreach ($head as $k => $v) {
                $h[$k] = mb_convert_encoding($v,'utf-8','gbk');
            }
            $rs = fputcsv($handle,$h);   //把表头写入文件
        }
        foreach ($data as $key => $v) {
            foreach ($v as $kk => $vv) {
                $v[$k] = mb_convert_encoding($vv,'utf-8','gbk');;//对中文编码进行处理
            }
            array_pop($v);
            $rs = fputcsv($handle, $v);
        }
    }

    //下载工作
    public function download(Request $request)
    {
        $file = public_path('/download/'.$request->route('file').'.csv');
        $order = 'e' . time();
        //写入数据库信息
        DB::table('export')->insert(['e_order'=>$order,'mg_id'=>get_mg_id(),'created_at'=>date('Y-m-d H:i:s',time())]);
        
        return response()->download($file);
    }
}
