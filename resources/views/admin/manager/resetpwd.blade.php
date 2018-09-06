@extends('admin/common/master')
@section('title','密码')
@section('class','body')
@section('content')
<blockquote class="layui-elem-quote layui-text">
    如果 {{$manager->mg_name}} 忘记了登录密码使用超级用户直接可以把密码重置了.
</blockquote>
<form class="layui-form" >
    <input type="hidden" name="mg_id" value="{{$manager->mg_id}}">
	<div class="layui-form-item">
        <label class="layui-form-label">用户名称</label>
        <div class="layui-input-block">
            <input type="text" name="mg_name" autocomplete="off" readonly class="layui-input" value="{{$manager->mg_name}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">重置密码</label>
        <div class="layui-input-block">
            <input type="text" name="password" autocomplete="off" placeholder="请输入密码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-block">
            <input type="text" name="confirmpwd" autocomplete="off" placeholder="请输入确认密码" class="layui-input">
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
    layui.use(['form'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

        //监听提交
        form.on('submit(demo1)', function(data){
        	var pwd = $('input[name="password"]').val();
            var mg_id = $('input[type="hidden"]').val();
        	var confirmpwd = $('input[name="confirmpwd"]').val();
        	if(pwd == '' && confirmpwd == ''){
        		layer.alert('重置密码和确认密码不得为空!')
        		return false;
        	}
        	if(pwd != confirmpwd){
        		layer.alert('重置密码和确认密码不一致!')
        		return false;
        	}
        	//ajax
        	$.ajax({
        		url:'{{url("/manager/resetpwd")}}',
        		data:{password:pwd,mg_id:mg_id},
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
                    if(data.code == 1){
                        parent.window.location.href = '{{url("/manager/index")}}';
                    }else if(data.code == 0){
                        layer.alert(data.error);
                    }
        		}
        	})
            
            return false;
        });


    });
</script>
@endsection