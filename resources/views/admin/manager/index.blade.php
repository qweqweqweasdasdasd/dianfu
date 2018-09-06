@extends('admin/common/master')
@section('title','用户列表')
@section('class','body')
@section('content')
<!-- 工具集 -->
<div class="my-btn-box">
    <span class="fl">
        <a class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加用户</a>
        <a class="layui-btn btn-add btn-default" id="white-btn"><i class="layui-icon">&#xe63c;</i>IP白名单</a>
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
    <span class="fr">
        <span class="layui-form-label">搜索条件：</span>
        <div class="layui-input-inline">
            <input type="text"  placeholder="请输入搜索条件" class="layui-input">
        </div>
        <button class="layui-btn mgl-20">查询</button>
    </span>
</div>
<input type="hidden" name="count" value="{{$count}}">
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col width="50">
		<col width="100">
		<col>
		<col>
		<col>
		<col>
		<col>
		<col width="100">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>用户名称</th>
			<th>用户组</th>
			<th>用户密码</th>
			<th>IP</th>
			<th>最后登录</th>
			<th>创建时间</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<!-- 数据存放 -->
	</tbody>
</table>
<span class="fr">
	<div id="demo4"></div>
</span>
@endsection
@section('my-js')
<script type="text/javascript">

    // layui方法
    layui.use(['table', 'form', 'layer', 'laypage'], function () {

        // 操作对象
        var form = layui.form
                , laypage = layui.laypage
                , layer = layui.layer
                , $ = layui.jquery;

        // 刷新
        $('#btn-refresh').on('click', function () {
            location.reload();
        });
        var count = $('input[name="count"]').val();
        //不显示首页尾页
		laypage.render({
		  elem: 'demo4'
		  ,count: count //数据总数，从服务端得到
		  ,limit: 7
		  ,jump: function(obj, first){

		    //ajax
			$.ajax({
				url:'{{url("/manager/index")}}',
				data:{page:obj.curr,pagesize:obj.limit,count:count},
				type:'post',
				dataType:'json',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					$('tbody').html('');
					if(data.code ==1){
						$('tbody').append(data.data);
					}
				}
			})
		    console.log(obj.curr); 
		    console.log(obj.limit); 
		    console.log(count); 
		  }
		});

		//数据初始化
		/*$(function(){
			//ajax
			$.ajax({
				url:'{{url("/manager/index")}}',
				data:'',
				type:'post',
				dataType:'json',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					$('tbody').html('');
					if(data.code ==1){
						$('tbody').append(data.data);
					}
				}
			})
		});*/

		//查看白名单
		$('#white-btn').click(function(){
			var index = layer.open({
				  type: 2,
				  title: '白名单',
				  shadeClose: true,
				  shade: 0.8,
				  area: ['1100px', '658px'],
				  content: '{{url("/whitelist")}}' //iframe的url
				}); 
			/*layer.full(index);*/
		})

		//搜索关键字
		$('.mgl-20').click(function(){
			var keyword = $('input[type="text"]').val();
			//ajax
			$.ajax({
				url:'{{url("/manager/index")}}',
				data:{keyword:keyword},
				type:'post',
				dataType:'json',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					$('tbody').html('');
					$('#demo4').html('');
					if(data.code ==1){
						$('tbody').append(data.data);
					}
				}
			})
		})

		//删除用户
		$('tbody').on('click','.del-btn',function(){
			var _this = $(this);
			var mg_id = $(this).attr('data-id');
			//ajax
			$.ajax({
				url:'{{url("/manager/del")}}',
				data:{mg_id:mg_id},
				dataType:'json',
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

		//修改状态
		$('tbody').on('click','.status-btn',function(){
			var _this = $(this);
			var mg_id = $(this).parent().parent().find('td:eq(0)').html();
			layer.confirm('需要改变用户的状态么', function(){
			   $.ajax({
					url:'{{url("/manager/setstatus")}}',
					data:{mg_id:mg_id},
					dataType:'json',
					type:'post',
					headers:{
						'X-CSRF-TOKEN':'{{csrf_token()}}'
					},
					success:function(data){
						if(data.code == 1){
							location.reload();
						}
					}
				})
			});
		});

		//添加用户
		$('#btn-add').click(function(){
			var index = layer.open({
			      type: 2,
			      title: '添加用户帮你做事吧',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			     
			      content: '{{url("/manager/create")}}'
			    });
			layer.full(index);
		});

		//编辑用户
		$('tbody').on('click','.go-btn',function(){
			var mg_id = $(this).attr('data-id');
			var _this = $(this);

			var index =	layer.open({
			      type: 2,
			      title: '用户编辑',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			     
			      content: '{{url("/manager/edit")}}'+'/'+mg_id
			    });
			layer.full(index);
		});

		//超级用户给用户重置密码
		$('tbody').on('click','.reset-btn',function(){
			var _this = $(this);
			var mg_id = _this.parent().parent().find('td:eq(0)').html();

			var index = layer.open({
			      type: 2,
			      title: '用户密码重置',
			      shadeClose: true,
			      shade: 0.8,

			      maxmin: true, //开启最大化最小化按钮
			      area: ['628px', '428px'],
			      content: '{{url("/manager/resetpwd")}}'+'/'+mg_id
			    });
		    layer.full(index);
		})
    });
</script>
@endsection