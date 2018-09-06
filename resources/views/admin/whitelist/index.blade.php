@extends('admin/common/master')
@section('title','白名单')
@section('class','body')
@section('content')
<div class="my-btn-box">
    <span class="fl">
        <a class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加IP</a>
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
</div>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col>
		<col>
		<col>
		<col>
		<col width="150px">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>IP地址</th>
			<th>操作者</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $v)
		<tr>
			<td>{{$v->w_id}}</td>
			<td>{{$v->ip_addr}}</td>
			<td>{{@$mg_index[$v->mg_id]}}</td>
			<td>{{$v->created_at}}</td>
			<td>
				<div class="layui-inline">
					<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="{{$v->w_id}}" ><i class="layui-icon">&#xe640;</i>删除</button>
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
    layui.use(['form', 'layer'], function () {

        // 操作对象
        var form = layui.form
                , layer = layui.layer   
                , $ = layui.jquery;
        //快捷添加ip地址
        $('#btn-add').click(function(){
        	layer.prompt({title: '以逗号分隔输入ip地址', formType: 2}, function(text, index){

        		//ajax
        		$.ajax({
        			url:'{{url("/whitelist/store")}}',
        			data:{shuju:text},
        			dataType:'json',
        			type:'post',
        			headers:{
        				'X-CSRF-TOKEN':'{{csrf_token()}}'
        			},
        			success:function(data){
        				if(data.code == 1){
        					$('#btn-refresh').click();
			    			layer.close(index);
        				}
        			}
        		})

			  });
 
        });

        //删除白名单
        $('tbody').on('click','.del-btn',function(){
        	var _this = $(this);
        	var w_id = $(this).parent().parent().parent().find('td:eq(0)').html();
        	var index = layer.confirm('确认需要删除么?', function(){
			  	//ajax
				  	$.ajax({
				  		url:'{{url("/whitelist/destroy")}}',
				  		data:{w_id:w_id},
				  		dataType:'json',
				  		type:'post',
				  		headers:{
				  			'X-CSRF-TOKEN':'{{csrf_token()}}'
				  		},
				  		success:function(data){
				  			if(data.code == 1){
				 				_this.parent().parent().parent().remove();
				  				debugger;
				  			}
				  		}
				  	})
				layer.close(index);
				});
        	
        });

        // 刷新
        $('#btn-refresh').on('click', function () {
            layer.msg('刷新成功!',function(){
            	 location.reload();
            });
        });
    });
</script>
@endsection