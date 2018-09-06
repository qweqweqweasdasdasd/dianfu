@extends('admin/common/master')
@section('title','工作流')
@section('class','body')
@section('content')
<blockquote class="layui-elem-quote layui-text">
    工作流: 请先点击处理然后进行回访,回访结束之后信息会自动消失
</blockquote>
<div class="my-btn-box">
	<span class="fl"> 
		<button class="layui-btn layui-btn-radius layui-btn-primary">今天总数 {{$todayCount}}</button>
		<button class="layui-btn layui-btn-radius layui-btn-primary">昨天未完成 {{$yesterdayNook}}</button>
		<button class="layui-btn layui-btn-radius layui-btn-primary">今天任务已处理 {{$todayOk}}</button>
	</span>
    <span class="fr">
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
</div>
<fieldset class="layui-elem-field">
    <legend>待回访列表</legend>
    <div class="layui-field-box">
       <table class="layui-table" lay-even lay-skin="line">
			<colgroup>
				<col>
				<col>
				<col>
				<col>
				<col width="80">
				<col width="250">
			</colgroup>
			<thead>
				<tr>
					<th>ID</th>
					<th>账号</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
				<tr>
					<td>{{$v->j_id}}</td>
					<td>{{$v->nikename}}</td>
					@if($v->status == 1)
					<td><span class="layui-badge layui-bg-orange">待处理</span></td>
					@elseif($v->status == 2)
					<td><span class="layui-badge layui-bg-danger">正在处理</span></td>
					@endif
					<td>
						<div class="layui-inline">
							<button class="layui-btn layui-btn-mini layui-btn-normal status-btn" j-id="{{$v->j_id}}" ><i class="layui-icon">&#xe642;</i>修改状态</button>
							<button class="layui-btn layui-btn-mini layui-btn  go-btn" j-id="{{$v->j_id}}" u-id="{{$v->u_id}}"><i class="layui-icon">&#xe654;</i>回访</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
    </div>
</fieldset>
@endsection
@section('my-js')
<script>
	layui.use(['form', 'jquery', 'layer'], function() {
		var form = layui.form
                , table = layui.table
                , layer = layui.layer
                , $ = layui.jquery;

        //修改状态
		$('tbody').on('click','.status-btn',function(){

			var j_id = $(this).attr('j-id');
			//debugger;
			//ajax
			$.ajax({
				url:'{{url("/work/workingstatus")}}',
				data:{j_id:j_id},
				dataType:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					if(data.code == 1){
						layer.msg('修改成功!',function(){
							window.location.href = window.location.href;
						})
					}
				}
			})
		});

		//添加回访页面显示
		$('tbody').on('click','.go-btn',function(){
			var j_id = $(this).attr('j-id');
			var u_id = $(this).attr('u-id');
	
			var _chuli = $(this).parent().parent().parent().find('td:eq(2) span').html();
			if(_chuli != '正在处理'){
				layer.alert('请先修改了状态之后,进行回访!');
				return false;
			}
			var index = layer.open({
			      type: 2,
			      title: '回访信息的添加',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			      //area: ['893px', '600px'],
			      content: '{{url("/work/add_visit")}}' + '/' + j_id + '/' + u_id
			    });
			layer.full(index);
		});

		//刷新当前页面
		$('#btn-refresh').click(function(){
			window.location.href = window.location.href;
		})
	});
</script>
@endsection