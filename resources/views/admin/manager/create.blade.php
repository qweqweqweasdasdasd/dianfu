@extends('admin/common/master')
@section('title','添加用户')
@section('class','body')
@section('content')
<form class="layui-form layui-form-pane" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="mg_name"  placeholder="输入用户名称" class="layui-input" value="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="password" name="password" placeholder="请输入密码"  class="layui-input" value="">
        </div>
        <div class="layui-form-mid layui-word-aux">请务必输入密码</div>
    </div>
    <div class="layui-form-item">
	    <div class="layui-block">
	        <label class="layui-form-label">选择用户组</label>
	        <div class="layui-input-block">
	            <select name="role_id"  lay-search="">
	                @foreach($role as $v)
	                <option value="{{$v->r_id}}">{{$v->r_name}}</option>
	       			@endforeach
	            </select>
	        </div>
	    </div>
	</div>
	<div class="layui-form-item" pane="">
        <label class="layui-form-label">开关</label>
        <div class="layui-input-block">
            <input type="checkbox" checked name="status" id="oo" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭" value="1">
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

        //监听指定开关
        form.on('switch(switchTest)', function(data){
        	$('input[name="status"]').attr('type','hidden').val(this.checked?'1':'0');
        	//$('input[name="status"]').prop('checked')? $(this).val(1) :$(this).val(0);
            layer.msg('用户状态：'+ (this.checked ? '开启' : '关闭'), {
                offset: '150px'
            });
        });

        //监听提交
        form.on('submit(demo1)', function(data){

        	$.ajax({
        		url:'{{url("/manager/stroe")}}',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
                    //debugger;
                    if(data.code == 1){
                        layer.alert('添加成功',function(){
                            parent.window.location.href = parent.window.location.href;
                        })
                    }
        		},
                error:function(jqXHR, textStatus, errorThrown){
                    var msg = '';
                    $.each(jqXHR.responseJSON,function(i,n){
                        msg += n;
                    })
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