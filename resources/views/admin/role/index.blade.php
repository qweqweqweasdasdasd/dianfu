@extends('admin/common/master')
@section('title','角色列表')
@section('class','body')
@section('content')
<div class="my-btn-box">
    <span class="fl">
        <a class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加用户组</a>
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
</div>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col>
		<col>
		<col>
		<col width="120">
		<col width="200">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>用户组名</th>
			<!-- <th>ps_ids</th> -->
			<th>权限分配方法</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($info as $v)
		<tr>
			<td>{{$v->r_id}}</td>
			<td>{{$v->r_name}}</td>
			<!-- <td>{{$v->ps_ids}}</td> -->
			<td>{{$v->ps_ca}}</td>
			<td>{{$v->created_at}}</td>
			<td>
				<div class="layui-inline">
					<button class="layui-btn layui-btn-mini layui-btn-warm go-btn" data-id="{{$v->r_id}}" ><i class="layui-icon">&#xe620;</i>分配权限</button>
					<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$v->r_id}}" ><i class="layui-icon">&#xe640;</i>删除</button>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
@section('my-js')
<script type="text/javascript">

    // layui方法
    layui.use(['table', 'form', 'layer'], function () {

        // 操作对象
        var form = layui.form
                , table = layui.table
                , layer = layui.layer
                , $ = layui.jquery;

        // 刷新
        $('#btn-refresh').on('click', function () {
            location.reload();
        });

        // 删除角色
        $('tbody').on('click','.del-btn',function(){
        	var del_id = $(this).attr('data-id');
        	var _this = $(this);
        	var index = layer.confirm('确定删除角色么?', function(){
				  $.ajax({
	        		url:'{{url("/role/del")}}',
	        		data:{id:del_id},
	        		dataType:'json',
	        		type:'post',
	        		headers:{
	        			'X-CSRF-TOKEN':'{{csrf_token()}}'
	        		},
	        		success:function(data){
	        			if(data.code == 1){
	        				_this.parent().parent().parent().remove()
	        			}
	        		}
	        	})
     		 layer.close(index);
			});
        });

        //添加用户组
        $('#btn-add').on('click',function(){
        	var index = layer.open({
			      type: 2,
			      title: '添加用户组',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			      
			      content: '{{url("/role/create")}}'
			    });
        	layer.full(index);
        })

        //权限分配
        $('tbody').on('click','.go-btn',function(){
        	var r_id = $(this).parent().parent().parent().find('td:eq(0)').html();
        	var index = layer.open({
		      type: 2,
		      title: '权限分配',
		      shadeClose: true,
		      shade: false,
		      maxmin: true, //开启最大化最小化按钮
		      content: '{{url("/role/qxview")}}' + '/' + r_id
		    });
		    layer.full(index);
        })
    });
</script>
@endsection