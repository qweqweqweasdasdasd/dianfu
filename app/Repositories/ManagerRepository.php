<?php 

namespace App\Repositories;

use App\Manager;
use App\Whitelist;
use Illuminate\Support\Facades\Hash;

class ManagerRepository 
{
	//记住ip地址和session_id 
	public function checkIpAndSessionId($ip,$session_id)
	{
		//ip 白名单验证
		if(!empty($ip)){
			foreach(Whitelist::get()->toArray() as $i){
				$allow_ip[] = $i['ip_addr'];
			};
			if(!in_array($ip,$allow_ip)){
				return false;
			}
		}
		$mg_id = \Auth::guard('back')->user()->mg_id;
		//如果当前登录的用户与session id 不匹配吧之前的用户强制退出
		$session = Manager::find($mg_id)->session_id;
		if($session === null){
			return Manager::where('mg_id',$mg_id)->update(['IP'=>$ip,'session_id'=>$session_id]);
		}
		if($session != $session_id){
			@unlink("/df/storage/framework/sessions/{$session}");	//删除文件名
			return Manager::where('mg_id',$mg_id)->update(['IP'=>$ip,'session_id'=>$session_id]);
		}
		//实现单用户登录

	}

	//记住最后一次登录的时间
	public function rememberLastTime()
	{
		$mg_id = \Auth::guard('back')->user()->mg_id;
		$now = date('Y-m-d H:i:s',time());
		return Manager::where('mg_id',$mg_id)->update(['last_login_time'=>$now]);
	}

	//获取到所有的管理员信息
	public function getManagerData($k,$d)
	{	
		$data = $this->paginate($d);
		
		return Manager::where(function($query) use($k){
							if(!empty($k)){
								$query->where('mg_name',$k);
							}
						})
						->offset($data['offset'])
						->limit($data['limit'])
						->get();
	}
	//获取所有的管理数量
	public function getManagerCount()
	{
		return Manager::count();
	}
	//分页处理
	public function paginate($d)
	{
		$page = $d['page'] ? $d['page'] : '0';
		$pagesize = $d['pagesize'] ? $d['pagesize'] : '7';

		$total_num = $this->getManagerCount();
		$page_num = ceil($total_num/$pagesize);
		
		if($page < 1){
			$page = 1;
		};
		if($page >= $page_num){
			$page = $page_num;
		};
		$offset = ($page-1)*$pagesize;
		return $d = [
			'offset'=>$offset,
			'limit'=>$pagesize
		];
	}
	//拼接管理员列表的html
	public function jointManagerTableHtml($d)
	{
		$html = '';
		foreach($d as $v) {
			$html .= $this->createManagerTableTr($v);
		}

		return $html;
	}

	//创建表单单行数据
	public function createManagerTableTr($d)
	{
		$d->status ? $status = 'warm' : $status = 'primary';	//笨办法
		$d->status ? $font = '正常' : $font = '禁用';	//笨办法

		$tr = '<tr><td>'.$d->mg_id.'</td>';
		$tr .= '<td>'.$d->mg_name.'</td>';
		$tr .= '<td>'.@$d->role->r_name.'</td>';
		if($d->mg_id == 1){
			$tr .= '<td></td>';
		}else{
			$tr .= '<td><a href="#" class="layui-btn layui-btn-mini layui-btn-normal reset-btn">用户密码</a></td>';
		}
		$tr .= '<td>'.$d->IP.'</td>';
		$tr .= '<td>'.$d->last_login_time.'</td>';
		$tr .= '<td>'.$d->created_at.'</td>';
		$tr .= '<td><button class="layui-btn layui-btn-mini layui-btn-'.$status.' status-btn">'.$font.'</button></td>';
		$tr .= '<td><div class="layui-inline"><button class="layui-btn layui-btn-mini layui-btn go-btn" data-id="'.$d->mg_id.'" ><i class="layui-icon">&#xe642;</i>编辑</button><button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="'.$d->mg_id.'" ><i class="layui-icon">&#xe640;</i>删除</button></div></td></tr>';
		
		return $tr;
	}

	//删除管理员用户
	public function delManager($id)
	{
		return Manager::where('mg_id',$id)->delete();
	}

	//修改管理员状态
	public function setManagerStatus($id)
	{
		if(!Manager::where('mg_id',$id)->value('status')){	//0

			return Manager::where('mg_id',$id)->update(['status'=>'1']);
		};
		
		return Manager::where('mg_id',$id)->update(['status'=>'0']);
	}

	//用户添加保存
	public function stroeManager(array $d)
	{
		$d['password'] = Hash::make($d['password']);
	
		return Manager::create($d);
	}

	//获取到一条数据
	public function getManagerById($id)
	{
		return Manager::find($id);
	}

	//更新一条数据
	public function updateManager($d)
	{	
		$mg_id = $d['mg_id'];

		return Manager::where('mg_id',$mg_id)->update(array_except($d,['mg_id','password']));
	}

	//密码重置
	public function updatepwd($d)
	{
		if(is_root()){
			return Manager::where('mg_id',$d['mg_id'])->update(['password'=>Hash::make($d['password'])]);
		}
		return false;
	}

	//检查管理员状态判断是否禁止登陆
	public function checkManagerSatatus()
	{

		$mg_id = \Auth::guard('back')->user()->mg_id;
	
		if(!Manager::where('mg_id',$mg_id)->value('status')){	//status == 0
			\Auth::guard('back')->logout();
			return false;
		};
		return true;
	}

	//修改密码的规则
	public function HashManager($d)
	{
		$hashedPassword = Manager::where('mg_id',get_mg_id())->value('password');
		if(!Hash::check($d['oldpwd'],$hashedPassword)){
			return false;
		}
		return true;
	}

	//修改密码
	public function updateManagerpassWord($d)
	{
		Manager::where('mg_id',get_mg_id())->update(['password'=>Hash::make($d)]);
		$this->rememberLastTime();
		return \Auth::guard('back')->logout();
		 
	}
}

?>