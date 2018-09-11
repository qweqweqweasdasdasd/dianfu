@extends('admin/common/master')
@section('title','模拟http')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<blockquote class="layui-elem-quote layui-text">
    导入之后系统会自动检测结果,导出之后所有的数据将会清除,搜狗游览器
</blockquote>
<div class="my-btn-box">
    <span class="fl">
        <button type="button" class="layui-btn" id="test1">
		  <i class="layui-icon">&#xe67c;</i>上传文件 5000
		</button>
        <a class="layui-btn layui-btn-warm" id="btn-curl">批量请求</a>
        <a class="layui-btn layui-btn-warm" id="shuaxin">刷新</a>
        <a class="layui-btn layui-btn-normal" id="btn-export">导出数据</a>
    </span>
    <!-- <span class="fr">
        <span class="layui-form-label">游览器：</span>
        <div class="layui-input-inline">
            <input type="text" autocomplete="off" placeholder="请输入搜索游览器" class="layui-input">
        </div>
        <button class="layui-btn mgl-20">发送请求</button>
    </span> -->
</div>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col width="50">
		<col width="60">
		<col width="80">
		<col width="350">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>关键词</th>
			<th>次数</th>
			
			<th>状态</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $v)
		<tr>
			<td>{{$v->k_id}}</td>
			<td>{{$v->keyword}}</td>
			<td>{{$v->status}}</td>	
			<td>
				
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
<script type="text/javascript">

    // layui方法
    layui.use(['table', 'form', 'layer' ,'upload'], function () {

        // 操作对象
        var form = layui.form
                , table = layui.table
                , layer = layui.layer
                , upload = layui.upload
                , $ = layui.jquery;

        // 刷新
        $('#btn-refresh').on('click', function () {
            tableIns.reload();
        });

        //执行实例
		var uploadInst = upload.render({
		    elem: '#test1' //绑定元素
		    ,url: '{{url("/upload")}}' //上传接口
		    ,accept : 'file'
		    ,done: function(res){
		      //上传完毕回调
		      if(res.code == 0){
		      	layer.alert(res.error);
		      }else if(res.code == 1){
		      	layer.msg('导入成功!');
		      }
		    }
		    ,error: function(){
		      //请求异常回调
		    }
		});

		//请求http
		$('#btn-curl').click(function(){
			$.ajax({
				url:'/todo',
				data:'',
				dataType:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					if(data.code == '0'){
						layer.alert(data.error);
					}else{
						window.location.href = window.location.href;
					}
				}
			})
		});
       
       //刷新
       $('#shuaxin').click(function(){
       		window.location.href = window.location.href;
       });
    });
</script>
@endsection