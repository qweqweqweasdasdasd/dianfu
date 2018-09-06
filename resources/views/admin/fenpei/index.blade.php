@extends('admin/common/master')
@section('title','分配工作')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<blockquote class="layui-elem-quote layui-text">
    分配工作: 按照用户组为单位,如果没有设置默认是不产生待处理回访,全部关闭之后默认直接产生待处理回访
</blockquote>
<div class="my-btn-box">
    <span class="fl">
        <a class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加分配规则</a>
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
    <form>
	    <span class="fr">
	        <span class="layui-form-label">搜索条件：</span>
	        <div class="layui-input-inline">
	            <input type="text" name="kk" placeholder="请输入搜索条件" class="layui-input" value="{{@$kk}}">
	        </div>
	        <button class="layui-btn mgl-20">查询</button>
	    </span>
    </form>
</div>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col >
		<col >
		<col >
		<col >
		<col >
		<col width="200">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>名称</th>
			<th>用户组 (组员)</th>
			<th>单日回访总数</th>
			<th>备注</th>
			<th>创建时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $v)
		<tr>
			<td>{{$v->f_id}}</td>
			<td>{{$v->title}}</td>
			<td>{{$v->r_name}}
				@foreach($v->role->manager as $vv)
				<span class="layui-badge layui-bg-gray">{{@$vv->mg_name}}</span>
				@endforeach
			</td>
			<td>{{$v->sum}} 个</td>
			<td>{{$v->desc}}</td>
			<td>{{$v->created_at}}</td>
			@if($v->status == 1)
			<td><button class="layui-btn layui-btn-mini layui-btn-warm">正常</button></td>
			@elseif($v->status == 0)
			<td><button class="layui-btn layui-btn-mini layui-btn-primary">停用</button></td>
			@endif
			<td>
				<div class="layui-inline">
					<button class="layui-btn layui-btn-mini layui-btn-normal go-btn" data-id="{{$v->f_id}}"><i class="layui-icon">&#xe642;</i>编辑</button>
					<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$v->f_id}}"><i class="layui-icon">&#xe640;</i>删除</button>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<span class="fr">
	{{ $data->links() }}
</span>
@endsection
@section('my-js')
<script>
    layui.use(['form', 'layer'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,$ = layui.$;

        //刷新
        $('#btn-refresh').click(function(){
        	window.location.href = window.location.href;
        });

        //添加分配规则
        $('#btn-add').click(function(){
        	var index = layer.open({
			      type: 2,
			      title: '开始分配工作了',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			      content: '{{url("/fenpei/create")}}'
			    });
        	layer.full(index);
        });

        //编辑分配规则
        $('tbody').on('click','.go-btn',function(){
        	var f_id = $(this).attr('data-id');
        	var index = layer.open({
			      type: 2,
			      title: '编辑分配工作',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			      content: '{{url("/fenpei/edit")}}' + '/' + f_id
			    });
        	layer.full(index);
        });
        //删除分配规则
        $('tbody').on('click','.del-btn',function(){
        	var f_id = $(this).attr('data-id');
        	var _this = $(this);
        	//ajax
        	$.ajax({
        		url:'{{url("/fenpei/destroy")}}',
        		data:{f_id:f_id},
        		dataType:'json',
        		type:'post',
        		headers:{
        			'X-CSRF-TOKEN':'{{csrf_token()}}'
        		},
        		success:function(data){
        			if(data.code == 1){
        				_this.parent().parent().parent().remove();
        			}else if(data.code == 0){
        				layer.alert(data.error);
        			}
        		}
        	})
        });
    });
</script>
@endsection