@extends('admin/common/master')
@section('title','回访记录')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<blockquote class="layui-elem-quote layui-text">
    工作流: 点击会员账号或者回访详情即可查询详情,回访退回到第二天才会显示到工作流上面,随机给分配
</blockquote>
<div class="my-btn-box">
	<span class="fl"> 
		<button class="layui-btn layui-btn-radius layui-btn-primary">总计数 {{$countByMg}}</button>
		<!-- <button class="layui-btn layui-btn-radius layui-btn-primary">今天总数 {{$todayOk}}</button> -->
	</span>
    <span class="fr">
    	<!-- <span class="layui-form-label">搜索条件：</span>
        <div class="layui-input-inline">
            <input type="text" autocomplete="off" placeholder="请输入会员账号" class="layui-input">
        </div>
        <button class="layui-btn mgl-20">查询</button> -->
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
</div>
<fieldset class="layui-elem-field">
    <legend>已回访列表</legend>
    <div class="layui-field-box">
       <table class="layui-table" lay-even lay-skin="line">
			<colgroup>
				<col width="50">
				<col width="80">
				<col width="100">
				<col width="250">
			</colgroup>
			<thead>
				<tr>
					<th>ID</th>
					<th>账号(查)</th>
					<th>回访详情(查)</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data as $v)
				<tr>
					<td>{{$v->j_id}}</td>
					<td><button class="layui-btn layui-btn-warm layui-btn-mini layui-btn-radius info" u-id="{{$v->u_id}}">{{$v->client->realname}}</button></td>
					<td><button class="layui-btn layui-btn-warm layui-btn-mini layui-btn-radius visit" u-id="{{$v->u_id}}">回访记录</button></td>
					<td>
						<div class="layui-inline">
							<button class="layui-btn layui-btn-mini layui-btn  rollback-btn" j-id="{{$v->j_id}}"><i class="layui-icon">&#xe642;</i>退回重新回访</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<span class="fr">
			{{ $data->links() }}	
		</span>
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

      
		//刷新当前页面
		$('#btn-refresh').click(function(){
			window.location.href = window.location.href;
		});

		//退回回访
		$('tbody').on('click','.rollback-btn',function(){
			var j_id = $(this).attr('j-id');
			var _this = $(this);
			//ajax
			$.ajax({
				url:'{{url("/work/rollback")}}',
				data:{j_id:j_id},
				datatype:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					if(data.code == 1){
						_this.parent().parent().parent().remove();
					}
				}
			})
		});

		//查看回访信息
		$('tbody').on('click','.visit',function(){
			var u_id = $(this).attr('u-id');
			
			//ajax
			layer.open({
		      type: 2,
		      title: '回访详情',
		      shadeClose: true,
		      shade: [0.5],
		      maxmin: true, //开启最大化最小化按钮
		      area: ['893px', '600px'],
		      content: '{{url("/work/visitzi")}}'+'/'+ u_id
		    });
		});

		//查看会员信息
		$('tbody').on('click','.info',function(){
			var u_id = $(this).attr('u-id');
	
			//ajax
			layer.open({
		      type: 2,
		      title: '会员详情',
		      shadeClose: true,
		      shade: [0.5],
		      maxmin: true, //开启最大化最小化按钮
		      area: ['893px', '600px'],
		      content: '{{url("/work/info")}}'+'/'+ u_id
		    });
		});
	});
</script>
@endsection