@extends('admin/common/master')
@section('title','数据导出')
@section('class','body')
@section('content')
<link rel="stylesheet" type="text/css" href="/admin/page.css">
<blockquote class="layui-elem-quote layui-text">
   导出数据建议日期不要太长:建议一周的时间
</blockquote>
<div class="my-btn-box">
    <span class="fl">
        <div class="layui-inline">
	      <label class="layui-form-label">日期范围</label>
	      <div class="layui-input-inline" style="width: 250px;">
	        <input type="text" class="layui-input" id="test6" placeholder="点击选择日期段" name="time">
	      </div>
	    </div>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="layui-btn mgl-20 export">导出回访记录</button>
    </span>
</div>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>数据导出历史记录</legend>
</fieldset>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col width="50">
		<col width="50">
		<col width="80">
		<col width="200">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>单号</th>
			<th>创建时间</th>
			<th>操作者</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $v)
		<tr>
			<td>{{$v->e_id}}</td>
			<td>{{$v->e_order}}</td>
			<td>{{$v->created_at}}</td>
			<td>{{$manager[$v->mg_id]}}</td>
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
    layui.use(['form', 'laydate'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,laydate = layui.laydate
                ,$ = layui.$;

         //日期范围
		laydate.render({
		    elem: '#test6'
		    ,range: '至'
		    ,format: 'yyyy-MM-dd'
		    ,min: -7 //7天前
		    ,max: 7 //7天后
		});

		//导出回访记录
		$('.export').click(function(){
			var _time = $('#test6').val();
			if(_time == ''){
				layer.alert('导出数据是需要填写日期的哦!');
				return false;
			}
			//ajax
			$.ajax({
				url:'{{url("/export")}}',
				data:{range:_time},
				dataType:'json',
				type:'post',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					console.log(data.data);
					window.location.href = data.data;
				}
			});
		})
    });
</script>
@endsection