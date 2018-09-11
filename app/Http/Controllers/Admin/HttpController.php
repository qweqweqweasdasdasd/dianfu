<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HttpController extends Controller
{
    //模拟http请求
    public function http()
    {
    	$data = DB::table('keyword')->paginate(11);

    	return view('admin.http.index',compact('data'));
    }

    //关键词导入
    public function upload(Request $request)
    {	
    	if(! $ext = $this->checkExt($_FILES['file'])){
    		return ['code'=>'0','error'=>'后缀名必须使用.csv'];
    	};
    	
    	if(!$this->checkSize($_FILES['file'])){
    		return ['code'=>'0','error'=>'文件不得超出 5M'];
    	};
    	//拼接服务器上的地址
    	$file_path = './download/keyword.' . $ext;
    	if(!move_uploaded_file($_FILES['file']['tmp_name'],$file_path)){
    		return ['code'=>'0','error'=>'文件上传失败,请重新上传!'];
    	}
    	if(!$this->csvDataInsertToDB($file_path)){
    		return ['code'=>'0','error'=>'文件数据不得超出50万!'];
    	}

    	//移动到指定的服务器位置
    	return ['code'=>1];
    }

    //数据处理导入数据库
    public function csvDataInsertToDB($file_path)
    {
    	ini_set('memory_limit','1024M');	//设置缓存
    	set_time_limit(0);	//执行脚本不限制时间
    	ignore_user_abort(true);	//游览器断开继续执行

    	$handle = fopen($file_path,'rb');
    	//讲文件一次性保存到数组内
    	$excelData = [];
    	while ($row = fgetcsv($handle)) {
    		$excelData[] = $row;
    	}
    	//数组的总长度
    	$total = count($excelData);
    	if($total > 100000){
    		return false;
    	}
    	$chunkData = array_chunk($excelData, 5000);
    	$now = date('Y-m-d H:i:s',time());
    	$count = count($chunkData);
    	
    	for ($i=0; $i < $count; $i++) { 
    		foreach ($chunkData[$i] as $v) {
    			$keyword = mb_convert_encoding($v[0],'utf-8','gbk');
    			$str = "('{$keyword}','{$now}')";
    			$value[] = $str;
    		}
    		//5000数据导入mysql
    
    		$data = implode(',', $value);
    		DB::insert(" INSERT INTO df_keyword(`keyword`,`created_at`) VALUES {$data}");
    		$value = [];
    	}
    	fclose($handle);
    	return ['code'=>1];
    }

    //检测后缀名
    public function checkExt($file)
    {
    	$ext = explode('.',$file['name']);	//csv
    	if($ext[1] != 'csv'){
    		return false;
    	}
    	return $ext[1];
    }

    //检测文件大小
    public function checkSize($file)
    {
    	$size = $file['size'];
    	if($size > 5*1024*1024){
    		return false;
    	}
    	return true;
    }

    //http请求操作
    public function todo()
    {
    	set_time_limit(0);
    	while (true) {
	    	//获取几条数据
	    	$first = DB::table('keyword')->whereNull('is_http')->first();
	    	
	    	$info = $this->sougou($first->keyword,$first->k_id);
            if($info['code'] == 0){
                return ['code'=>0,'error'=>$info['error']];
            }
    	}
    }

    //搜狗游览器
    public function sougou($keyword,$k_id)
    {
    	error_reporting(0);
        $url = "http://www.sogou.com/web?query=" . urlencode($keyword);  //http://www.google.com/search?q=
        $str = $this->mycurl($url);

        preg_match("/<p class=\"num-tips\">.*?<\/p>/", $str, $content); //解决了数字的问题
        if($content == []){
            return ['code'=>0,'error'=>'请更换ip地址'];
        }
        $string = str_replace(',','',$content);
        
        preg_match('/<p class=\"num-tips\">.*?(\d+).*?<\/p>/',$string[0],$cont);

        if($str === false){
            return DB::table('keyword')->where('k_id',$k_id)->update(['status'=>'0','is_http'=>1]);
        }
        $z = DB::table('keyword')->where('k_id',$k_id)->update(['status'=>$cont[1],'is_http'=>1]);

        return $z ? ['code'=>1,'cont'=>$cont[1]] :['code'=>0];
    }

    //发送curl函数
    public function mycurl($url)
    {
    	//初始化
    	$ch = curl_init();
        //使用代理
    	//设置选项,包括url
    	curl_setopt($ch,CURLOPT_URL,$url); //需要获取的 URL 地址 
    	curl_setopt($ch,CURLOPT_TIMEOUT,3);	//可以执行最长的秒数
		curl_setopt($ch,CURLOPT_HEADER,true);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);	//文件流的形式返回

        curl_setopt($ch,CURLOPT_PROXY, $this->getip());  //代理服务器地址    data5u
    
        //抓取中任何跳转带来的问题
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        $output = curl_exec($ch);
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        
        curl_close($ch);
		return $output;
    }

    public function getip()
    {
        $arr = [
            '0'=>'140.227.65.196:3128',
            '1'=>'153.149.169.64:3128',
            '2'=>'60.250.79.187:80',
            '3'=>'101.227.5.36:9000'
        ];
        $index = rand(0,count($arr)-1);
        return $arr[$index];
    }



}
