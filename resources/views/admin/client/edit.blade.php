@extends('admin/common/master')
@section('title','编辑客户')
@section('class','body')
@section('content')
<form class="layui-form" action="">
	<input type="hidden" name="u_id" value="{{$info->u_id}}">
    <div class="layui-form-item">
        <label class="layui-form-label">会员账号</label>
        <div class="layui-input-block">
            <input type="text" name="nikename"  value="{{$info->nikename}}" placeholder="会员账号" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">真实姓名</label>
        <div class="layui-input-block">
            <input type="text" name="realname"  value="{{$info->realname}}" placeholder="真实姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号码</label>
        <div class="layui-input-block">
            <input type="text" name="tel"  value="{{$info->tel}}" placeholder="手机号码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属平台</label>
        <div class="layui-input-block">
            <input type="text" name="pingtai"  value="{{$info->pingtai}}" placeholder="所属平台" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">注册时间</label>
        <div class="layui-input-block">
            <input type="text" name="regtime"  value="{{$info->regtime}}" placeholder="注册时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">最后登录时间</label>
        <div class="layui-input-block">
            <input type="text" name="loginlasttime"  value="{{$info->loginlasttime}}" placeholder="最后登录时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">代理</label>
        <div class="layui-input-block">
            <input type="text" name="daili"  value="{{$info->daili}}" placeholder="代理" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">网址</label>
        <div class="layui-input-block">
            <input type="text" name="http"  value="{{$info->http}}" placeholder="网址" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">存款金额</label>
        <div class="layui-input-block">
            <input type="text" name="c_money"  value="{{$info->c_money}}" placeholder="存款金额" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提款金额</label>
        <div class="layui-input-block">
            <input type="text" name="t_money"  value="{{$info->t_money}}" placeholder="提款金额" class="layui-input">
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
    layui.use(['form', 'layer'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

       
        //监听提交
        form.on('submit(demo1)', function(data){
        	//ajax
        	$.ajax({
        		url:'{{url("/client/update")}}',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 1){
        				layer.alert('更新成功',function(){
        					parent.window.location.href = '{{url("/client/show")}}';
        				})
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
       
        		}
        	})
            return false;
        });


    });
</script>
@endsection