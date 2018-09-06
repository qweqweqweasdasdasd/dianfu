@extends('admin/common/master')
@section('title','权限分配')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/h-ui/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/h-ui/static/h-ui.admin/css/H-ui.admin.css" />
<blockquote class="layui-elem-quote layui-text">
    权限分配 (有时好奇是会害死猫的)
</blockquote>
<article class="page-container">
<form method="post" class="form form-horizontal" id="form-admin-role-add">
	<input type="hidden" name="r_id" value="{{$info->r_id}}">
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">用户组名称：</label>
		<div class="formControls col-xs-8 col-sm-10">
			<input type="text" class="input-text" value="{{$info->r_name}}" readonly  name="r_name">
		</div>
	</div>
	<div class="row cl">
		<label class="form-label col-xs-4 col-sm-1">权限列表：</label>
		<div class="formControls col-xs-8 col-sm-10">
			@foreach($permission_0 as $v)
			<dl class="permission-list">
				<dt>
					<label>
						<input type="checkbox" value="{{$v->p_id}}" name="qx[]" 
						@if(in_array($v->p_id,$ps_idsArr))
							checked
						@endif
						>
						{{$v->p_name}}</label>
				</dt>
				<dd>
					@foreach($permission_1 as $vv)
					@if($vv->ps_pid == $v->p_id)
					<dl class="cl permission-list2">
						<dt>
							<label class="">
								<input type="checkbox" value="{{$vv->p_id}}" name="qx[]" 
								@if(in_array($vv->p_id,$ps_idsArr))
									checked
								@endif>
								{{$vv->p_name}}</label>
						</dt>
						<dd>
							@foreach($permission_2 as $vvv)
							@if($vvv->ps_pid == $vv->p_id)
							<label class="">
								<input type="checkbox" value="{{$vvv->p_id}}" name="qx[]" 
								@if(in_array($vvv->p_id,$ps_idsArr))
									checked
								@endif>
								{{$vvv->p_name}}</label>
							@endif
							@endforeach
						</dd>
					</dl>
					@endif
					@endforeach
				</dd>
			</dl>
			@endforeach
		</div>
	</div>
	<div class="row cl">
		<div class="col-xs-8 col-sm-10 col-xs-offset-4 col-sm-offset-2">
			<button type="submit" class="btn btn-success"  style="width: 100px;"><i class="icon-ok"></i> 确定</button>
		</div>
	</div>
</form>
</article>
@endsection
@section('my-js')
<script>
    layui.use(['form'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

        $(function(){
			$(".permission-list dt input:checkbox").click(function(){
				$(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
			});
			$(".permission-list2 dd input:checkbox").click(function(){
				var l =$(this).parent().parent().find("input:checked").length;
				var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
				if($(this).prop("checked")){
					$(this).closest("dl").find("dt input:checkbox").prop("checked",true);
					$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
				}
				else{
					if(l==0){
						$(this).closest("dl").find("dt input:checkbox").prop("checked",false);
					}
					if(l2==0){
						$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
					}
				}
			});
			
		});

		//提交保存数据
		$('#form-admin-role-add').submit(function(evt){
			evt.preventDefault();
			var shuju = $(this).serialize();
			if($('input[type="checkbox"]:checked').length <= 0){
				layer.alert('权限必须选中一个!');
				return false;
			};
			
			//ajax
			$.ajax({
				url:'{{url("/role/qxsave")}}',
				data:shuju,
				dataType:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					if(data.code == 1){
						layer.alert('分配成功',function(){
        					parent.window.location.href = parent.window.location.href;
        				})
					}
				}
			})
		});

    });
</script>
@endsection