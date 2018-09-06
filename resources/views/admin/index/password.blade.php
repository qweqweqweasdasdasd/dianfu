@extends('admin/common/master')
@section('title','密码')
@section('class','body')
@section('content')
<blockquote class="layui-elem-quote layui-text">
    密码修改之后需要重新登录
</blockquote>
<br/>
<form class="layui-form layui-form-pane">
	<div class="layui-form-item">
        <label class="layui-form-label">原始密码</label>
        <div class="layui-input-block">
            <input type="text" name="oldpwd" autocomplete="off" placeholder="请输入原始密码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-block">
            <input type="text" name="newpwd"  placeholder="请输入新密码" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-block">
            <input type="text" name="comfirmpwd"  placeholder="请确认密码" autocomplete="off" class="layui-input">
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
            var oldpwd = $('input[name="oldpwd"]').val();
            var newpwd = $('input[name="newpwd"]').val();
            var comfirmpwd = $('input[name="comfirmpwd"]').val();
            if(oldpwd == '' || newpwd == '' || comfirmpwd == ''){
                layer.alert('初始密码,重置密码和确认密码不得为空!');
                return false;
            }
            if(newpwd != comfirmpwd){
                layer.alert('重置密码和确认密码不得一致!');
                return false;
            }

        	//ajax 
        	$.ajax({
        		url:'',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 1){
                        parent.window.location.href = '{{url("/login")}}';
                    }
        		}
        	})
            return false;
        });


    });
</script>
@endsection