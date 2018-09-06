@extends('admin/common/master')
@section('title','权限列表')
@section('class','body')
@section('content')
<!-- 工具集 -->
<blockquote class="layui-elem-quote layui-text">
   <div class="my-btn-box">
	    <span class="fl">
	        <button class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加权限</button>
	        <button class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加权限之后刷新一下才会显示
	    </span>
	</div>
</blockquote>

<div class="layui-collapse" lay-accordion="">
    <div class="layui-colla-item">
        <h2 class="layui-colla-title">展开权限列表</h2>
        <div class="layui-colla-content layui-show">
			<div class="layui-form" id="table-list">
				<table class="layui-table" lay-even lay-skin="line">
					<colgroup>
						<col width="50">
						<col width="150">
						<col width="150">
						<col>
						<col>
						<col width="200">
						<col width="200">
					</colgroup>
					<thead>
						<tr>
							<th>ID</th>
							<th>权限名称</th>
							<th>控制器</th>
							<th>方法</th>
							<th>路由</th>
							<th>创建时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tree as $v)
						<tr>
							<td>{{ $v['p_id'] }}</td>
							<td>{{ str_repeat('&nbsp;&nbsp;&nbsp;',$v['ps_level']).$v['p_name'] }}</td>
							<td>{{ $v['ps_c'] }}</td>
							<td>{{ $v['ps_a'] }}</td>
							<td>{{ $v['ps_route'] }}</td>
							<td>{{ $v['created_at'] }}</td>
							<td>
								<div class="layui-inline">
									<button class="layui-btn layui-btn-mini layui-btn-normal  go-btn" data-id="{{ $v['p_id'] }}" ><i class="layui-icon">&#xe642;</i>编辑</button>
									<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{ $v['p_id'] }}" ><i class="layui-icon">&#xe640;</i>删除</button>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
        </div>
    </div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
    layui.use(['element', 'layer'], function () {
        var element = layui.element
                , layer = layui.layer
                ,	$ = layui.$;

        // 刷新
        $('#btn-refresh').on('click', function () {
            location.reload();
        });

        //添加权限信息
        $('#btn-add').on('click',function(){
	        var index =	layer.open({
			      type: 2,
			      title: '添加权限信息',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			     
			      content: '{{url("/permission/create")}}'
			    });
	        layer.full(index);
        });

        //编辑页面的显示
        $('tbody').on('click','.go-btn',function(obj){
        	var edit_id = $(this).attr('data-id');
	        var index =	layer.open({
			      type: 2,
			      title: '编辑权限信息',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			    
			      content: '{{url("/permission/show")}}' + '/'+ edit_id
			});
			layer.full(index);
       
        })

        //删除权限信息
        $('tbody').on('click','.del-btn',function(){
        	var _this = $(this);
        	var del_id = $(this).attr('data-id');
	        var index =	layer.confirm('确定需要删除这个权限？', function(){
					$.ajax({
		        		url:'{{url("/permission/del")}}',
		        		data:{id:del_id},
		        		dataType:'json',
		        		type:'post',
		        		headers:{
		        			'X-CSRF-TOKEN':'{{csrf_token()}}'
		        		},
		        		success:function(data){
		        			if(data.code == 1){
		        				_this.parent().parent().parent().remove()
		        			}else if(data.code == 0){
		        				layer.msg(data.error);
		        			}
		        		}
		        	})
        	layer.close(index);
			});
        })
    });
</script>
@endsection