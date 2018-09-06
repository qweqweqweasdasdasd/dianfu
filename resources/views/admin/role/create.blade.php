@extends('admin/common/master')
@section('title','添加用户组')
@section('class','body')
@section('content')
<form class="layui-form layui-form-pane" action="">
    <div class="layui-form-item">
        <label class="layui-form-label">用户组</label>
        <div class="layui-input-block">
            <input type="text" name="r_name" autocomplete="off" placeholder="请输入用户组" class="layui-input">
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
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

        //监听提交
        form.on('submit(demo1)', function(data){
        	if(data.field.r_name == ''){
        		layer.alert('用户组名称不得为空!');
        		return false;
        	};

        	//ajax
        	$.ajax({
        		url:'{{url("/role/store")}}',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 1){
        				layer.alert('添加成功',function(){
        					parent.window.location.href = parent.window.location.href;
        				})
        			}
        		}
        	});
  
            return false;
        });


    });
</script>
@endsection