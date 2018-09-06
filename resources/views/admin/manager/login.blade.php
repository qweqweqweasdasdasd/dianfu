@extends('admin/common/master')
@section('title','login')
@section('class','login-body body')
@section('content')
<div class="login-box">
    <form class="layui-form layui-form-pane">
        <div class="layui-form-item">
            <h3>后台管理系统</h3>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号：</label>

            <div class="layui-input-inline">
                <input type="text" name="mg_name" class="layui-input"  placeholder="账号" autocomplete="on" />
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码：</label>

            <div class="layui-input-inline">
                <input type="password" name="password" class="layui-input"  placeholder="密码" />
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">验证码：</label>

            <div class="layui-input-inline">
                <input type="number" name="code" class="layui-input"  placeholder="验证码" /><img
                    src="{{url(captcha_src())}}" onclick="this.src='{{url(captcha_src())}}'+'?'+ Math.random()">
            </div>
        </div>
        <div class="layui-form-item">
            <button type="reset" class="layui-btn layui-btn-danger btn-reset">重置</button>
            <button type="button" class="layui-btn btn-submit" lay-submit="" lay-filter="sub">立即登录</button>
        </div>
    </form>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
    layui.use(['form', 'layer'], function () {

        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;

        // 提交监听
        form.on('submit(sub)', function (data) {
        	//ajax
        	$.ajax({
        		url:'{{url("/storemanager")}}',
        		data:data.field,
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 0){
        				return layer.alert(data.error);
        			}else if(data.code == 4){
                        return layer.alert(data.error,function(){
                            window.location.href = "{{url('/login')}}";
                        });
                    }
        			window.location.href = "{{url('/index/index')}}";
        		},
        		error:function(jqXHR, textStatus, errorThrown){
        			var msg = '';
        			$.each(jqXHR.responseJSON,function(i,n){
        				msg += n;
        			})
        			if(msg !=''){
        				layer.alert(msg);
        			}
        		}
        	})
            return false;
        });
    })

</script>
@endsection