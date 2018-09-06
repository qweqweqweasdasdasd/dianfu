@extends('admin/common/master')
@section('title','编辑显示')
@section('class','body')
@section('content')
<form class="layui-form" action="">
	<input type="hidden" name="f_id" value="{{$info->f_id}}">
    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="title"  placeholder="请输入标题" class="layui-input" value="{{$info->title}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择用户组</label>
        <div class="layui-input-block">
            <select name="r_id" >
                @foreach($role as $v)
                <option value="{{$v->r_id}}" 
                @if($v->r_id == $info->r_id)
       			selected
       			@endif
                >{{$v->r_name}}</option>     
                @endforeach
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline" >
            <label class="layui-form-label">回访数量</label>
            <div class="layui-input-inline">
                <input type="number" name="sum" class="layui-input" max="800" min="100" step="50" value="{{$info->sum}}">
            </div>
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">开关-默认开</label>
        <div class="layui-input-block">
            <input type="checkbox" name="status" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF" value="1"
        	@if($info->status == 1)
        	checked
        	@endif
            >
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注详情</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="desc">{{$info->desc}}</textarea>
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



        //监听指定开关
        form.on('switch(switchTest)', function(data){
            $('input[name="status"]').attr('type','hidden').val(this.checked?'1':'0');
            //$('input[name="status"]').attr('type','hidden').prop('checked')? $(this).val(1) : $(this).val(0);
            layer.msg('开关状态：'+ (this.checked ? '开启' : '关闭'), {
                offset: '15px'
            });
        });

        //监听提交
        form.on('submit(demo1)', function(data){
            //ajax
            $.ajax({
                url:'{{url("/fenpei/update")}}',
                data:data.field,
                dataType:'json',
                type:'post',
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                },
                success:function(data){
                    if(data.code == 1){
                    	layer.alert('保存成功',function(){
                        	parent.window.location.href = '{{url("/fenpei/index")}}';
                    	})
                    }else if(data.code == 0){
                        layer.alert(data.error);
                    }
                },
                error:function(jqXHR, textStatus, errorThrown){
                    var msg = ''
                    $.each(jqXHR.responseJSON,function(i,n){
                        msg += n;
                    });
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