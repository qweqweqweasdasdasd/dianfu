@extends('admin/common/master')
@section('title','编辑权限信息')
@section('class','body')
@section('content')
<form class="layui-form">
	<input type="hidden" name="p_id" value="{{$info->p_id}}">
    <div class="layui-form-item">
        <label class="layui-form-label">权限名称</label>
        <div class="layui-input-block">
            <input type="text" name="p_name"  placeholder="请输入权限名称信息" class="layui-input" value="{{$info->p_name}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">上级权限</label>
        <div class="layui-input-block">
            <select name="ps_pid" lay-filter="aihao">
            	@foreach($tree as $v)
                <option value="{{$v['p_id']}}"
                @if($info->ps_pid == $v['p_id'])
                selected
                @endif
                >{{ str_repeat('&nbsp;&nbsp;&nbsp;',$v['ps_level']).$v['p_name']}}</option>
             	@endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-block">
            <input type="text" name="ps_c"  placeholder="请输入控制器信息" class="layui-input" value="{{$info->ps_c}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-block">
            <input type="text" name="ps_a"  placeholder="请输入方法信息" class="layui-input" value="{{$info->ps_a}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">路由</label>
        <div class="layui-input-block">
            <input type="text" name="ps_route"  placeholder="请输入路由信息" class="layui-input" value="{{$info->ps_route}}">
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
            //ajax
            $.ajax({
            	url:'{{url("/permission/save")}}',
            	data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
            	success:function(data){
                    if(data.code == 1){
                        layer.alert('编辑权限信息成功',function(){
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
            			layer.msg(msg);
            		}
            	}
            })
            return false;
        });


    });
</script>
@endsection