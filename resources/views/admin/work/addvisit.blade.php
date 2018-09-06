@extends('admin/common/master')
@section('title','添加回访显示')
@section('class','body')
@section('content')
<form class="layui-form" >
	<div class="layui-form-item">
		<div class="layui-input-block">
	        <table class="layui-table">
			    <thead>
			    <tr>
			        <th colspan="18">个人信息详情</th>
			    </tr>
			    </thead>
			    <tbody>
				    <tr>
				        <td>姓名</td>
				        <td>手机号</td>
				        <td>平台</td>
				        <td>注册时间</td>
				        <td>最后登录时间</td>
				        <td>代理</td>
				        <td>网址</td>
				        <td>存款金额</td>
				        <td>提款金额</td>
				    </tr>
				    <tr>
				        <td>{{$info->realname}}</td>
				        <td>{{$info->tel}}</td>
				        <td>{{$info->pingtai}}</td>
				        <td>{{$info->regtime}}</td>
				        <td>{{$info->loginlasttime}}</td>
				        <td>{{$info->daili}}</td>
				        <td>{{$info->http}}</td>
				        <td>{{$info->c_money}}</td>
				        <td>{{$info->t_money}}</td>
				     </tr>
			    </tbody>
                <tbody>
                    <tr>
                         <td>回访ID</td>
                         <td>回访目的</td>
                         <td>回访内容</td>
                         <td>操作者</td>
                         <td>回访时间</td>
                     </tr>
                    @foreach($jobs as $job)
                    @foreach($job->visit as $visit)
                    <tr>
                        <td>{{$job->u_id}}</td>
                        <td>{{$visit->title}}</td>
                        <td>{{$visit->content}}</td>
                        <td>{{$manager[$job->mg_id]}}</td>
                        <td>{{$visit->created_at}}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
			</table>
		</div>
	</div>
	<input type="hidden" name="j_id" value="{{$info->j_id}}">
	<input type="hidden" name="u_id" value="{{$info->u_id}}">
    <div class="layui-form-item">
        <label class="layui-form-label">回访目的</label>
        <div class="layui-input-block">
            <input type="text" name="title" placeholder="请描述一下回访的目的" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">回访记录</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入回访记录内容" class="layui-textarea" name="content"></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection
@section('my-js')
<script>
    layui.use(['form','layer' ], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

   
        //监听提交
        form.on('submit(demo1)', function(data){
        	
        	//ajax
        	$.ajax({
        		url:'{{url("/work/store")}}',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 1){
        				parent.window.location.href = '{{url("/work/index")}}';
        			}
        		},
        		error:function(jqXHR, textStatus, errorThrown){
        			var msg = '';
        			$.each(jqXHR.responseJSON,function(i,n){
        				msg += n;
        			});
        			if(msg != ''){
        				layer.alert(msg);
        			}
        			//console.log(jqXHR.responseJSON);
        		}
        	})
            return false;
        });


    });
</script>
@endsection