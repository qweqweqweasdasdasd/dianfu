@extends('admin.common.master')
@section('title','导入页面')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<blockquote class="layui-elem-quote layui-text">
   	CSV数据导入5万,(如有重复自动忽略) 格式:账号(唯一),姓名,手机号,平台,注册时间,最后登录日期,代理,网址,存款总额,提款总额
</blockquote>
<!-- 工具集 -->
<span class="fl">
    <button type="button" class="layui-btn" id="test1">
	  <i class="layui-icon">&#xe67c;</i>上传CSV数据 5万
	</button>
    <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
</span>
<form class="layui-form">
<div class="my-btn-box">
    <span class="fr">
        <span class="layui-form-label">搜索条件：</span>
        <div class="layui-input-inline">
            <input type="text" name="k" placeholder="请输入单号或操作者" class="layui-input" value="{{@$k}}">
        </div>
        <button class="layui-btn mgl-20">查询</button>
    </span>
</div>
</form>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col>
		<col>
		<col>
		<col>
		<col>
		<col width="200">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>单号</th>
			<th>数量</th>
			<th>操作者</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $v)
		<tr>
			<td>{{$v->i_id}}</td>
			<td>{{$v->order_li}}</td>
			<td>{{$v->count}}</td>
			<td>{{$v->mg_name}}</td>
			<td>{{$v->created_at}}</td>
			<td>
				<div class="layui-inline">
					<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-order="{{$v->order_li}}" ><i class="layui-icon">&#xe640;</i>数据回滚</button>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<span class="fr">
	{{ $data->appends(['k'=>$k])->links() }}
</span>
@endsection
@section('my-js')
<script type="text/javascript">

    // layui方法
    layui.use(['table', 'form', 'layer', 'upload'], function () {

        // 操作对象
        var form = layui.form
                , table = layui.table
                , layer = layui.layer
                , upload = layui.upload
                , $ = layui.jquery;

        // 刷新
        $('#btn-refresh').on('click', function () {
            window.location.href = window.location.href;
        });

        //数据回滚 (物理删除)
        $('tbody').on('click','.del-btn',function(){
        	var order_li = $(this).attr('data-order');
        	var _this = $(this);
        	layer.confirm('这个删除是永久的删除,无法找回', function(){
			  	//ajax
	        	$.ajax({
	        		url:'{{url("/rollback")}}',
	        		data:{order_li:order_li},
	        		dataType:'json',
	        		type:'post',
	        		headers:{
	        			'X-CSRF-TOKEN':'{{csrf_token()}}'
	        		},
	        		success:function(data){
	        			if(data.code == 1){
	        				_this.parent().parent().parent().remove();
	        				layer.msg('数据删除成功!');
	        			}else if(data.code == 0){
	        				_this.parent().parent().parent().remove();
	        				layer.msg(data.error);
	        			}
	        		}
	        	})

			});
        		
        });

        //文件上传
		var uploadInst = upload.render({
		    elem: '#test1' //绑定元素
		    ,url: '{{url("/import")}}' //上传接口
		    ,accept: 'file'
		    ,method: 'post'
		    ,before: function(obj){ 
			  index = layer.load(1,{
			    	shade:[0.3,'#fff']	//0.1透明度的白色背景
			    });
			}
		    ,done: function(res){
		      //上传完毕回调
		      if(res.code == 0){
		      	layer.close(index);
		      	layer.alert(res.error);
		      }else if(res.code == 1){
		      	layer.close(index);
		      	layer.msg('导入成功!');
		      	$('#btn-refresh').click();
		      }
		    }
		    ,error: function(){
		      //请求异常回调
		    }
		});

    });
</script>
@endsection