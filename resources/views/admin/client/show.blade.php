@extends('admin/common/master')
@section('title','客户信息')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">

<div class="my-btn-box">
    <span class="fl">
        <!-- <a class="layui-btn btn-add btn-default" id="btn-add"><i class="layui-icon">&#xe654;</i>添加客户</a> -->
        <a class="layui-btn btn-add btn-default" id="btn-refresh">
    		刷新总数
    		<span class="layui-badge layui-bg-orange">{{$count}}</span>
        </a>
    </span>
    <form class="layui-form">
	    <span class="fr">
	        <span class="layui-form-label">搜索条件：</span>
	        <div class="layui-input-inline">
	            <input type="text"  placeholder="请输入账号/手机号/平台" class="layui-input" name="key" value="{{@$key}}">
	        </div>
	        <button class="layui-btn mgl-20">查询</button>
	    </span>
    </form>
</div>

<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col>
		<col>
		<col>
		<col>
		<col>
		<col>
		<col>
		<col width="150">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>姓名</th>
			<th>账号</th>
			<!-- <th>手机号</th> -->
			<th>平台</th>
			<th>存款金额</th>
			<th>提款金额</th>
			<th>创建时间</th>
			<th>回访状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		@foreach($client as $k => $v)
		<tr>
			<td>{{$v->u_id}}</td>
			<td><a  class="layui-btn layui-btn-mini check-info" data-u_id="{{$v->u_id}}">{{$v->realname}}</a></td>
			<td>{{$v->nikename}}</td>
			<!-- <td>{{$v->tel}}</td> -->
			<td>{{$v->pingtai}}</td>
			<td><span style="color: #009933">{{$v->c_money}} 元</span></td>
			<td><span style="color: #ff3333">-{{$v->t_money}} 元</span></td>
			<td>{{$v->created_at}}</td>
			@if($v->status == 1)
			<td><span class="layui-badge layui-bg-orange">待处理</span></td>
			@elseif($v->status == 0)
			<td><span class="layui-badge layui-bg-blue">未回访</span></td>
			@elseif($v->status == 2)
			<td><span class="layui-badge layui-bg-danger">正在处理</span></td>
			@elseif($v->status == 3)
			<td><span class="layui-badge layui-bg-gray">回访完毕</span></td>
			@endif
			<td>
				<div class="layui-inline">
					<button class="layui-btn layui-btn-mini layui-btn-normal go-btn" u-id="{{$v->u_id}}" ><i class="layui-icon">&#xe642;</i>编辑客户信息</button>
<!-- 					<button class="layui-btn layui-btn-mini layui-btn-danger del-btn" data-id="1" data-url="article-detail.html"><i class="layui-icon">&#xe640;</i>删除</button> -->
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<span class="fr">
	{{ $client->appends(['key'=>$key])->links() }}	
</span>
@endsection
@section('my-js')
<script type="text/javascript">

    // layui方法
    layui.use(['form', 'layer'], function () {

        // 操作对象
        var form = layui.form
                , layer = layui.layer
                , $ = layui.jquery;

      
        // 刷新
        $('#btn-refresh').on('click', function () {
            window.location.href = window.location.href;
        });

        //查看详情
        $('tbody').on('click','.check-info',function(){
        	var u_id = $(this).attr('data-u_id');
        	var u_name = $(this).parent().parent().find('td:eq(1) a').html();
   
        	var index = layer.open({
			      type: 2,
			      title: u_name + '-的详情',
			      shadeClose: true,
			      shade: [0.5],
			      maxmin: true, //开启最大化最小化按钮
			      area: ['691px', '450px'],
			      content: '{{url("/client/info")}}' + '/' + u_id
			    });
        	//layer.full(index);
        })

        //编辑显示
        $('tbody').on('click','.go-btn',function(){
        	var u_id = $(this).attr('u-id');

        	var index =	layer.open({
			      type: 2,
			      title: '客户信息编辑',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			     
			      content: '{{url("/client/edit")}}'+'/'+u_id	
			    });
        	layer.full(index);
        });

    });
</script>
@endsection