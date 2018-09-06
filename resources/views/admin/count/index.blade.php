@extends('admin/common/master')
@section('title','统计数据')
@section('class','body')
@section('content')
<div class="my-btn-box">
    <span class="fl">
    	<div class="layui-inline">
	      <label class="layui-form-label">月份选择</label>
	      <div class="layui-input-inline">
	        <input type="text" class="layui-input" id="test5" placeholder="根据月份进行查询" value="">
	      </div>
	    </div>
        <button class="layui-btn mgl-20 month">查询</button>
    </span>
    <span class="fr">
        <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
    </span>
</div>
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col width="50">
		<col width="50">
		<col width="300">
		<col>
	</colgroup>
	<thead>
		<tr>
			<th>姓名</th>
			<th>月回访次数</th>
			<th>月内查询</th>
		</tr>
	</thead>
	<tbody>
	<!-- 数据存放 -->		
	</tbody>
</table>
@endsection
@section('my-js')
<script>
    layui.use(['form', 'laydate'], function(){
        var form = layui.form
                ,layer = layui.layer
                ,laydate = layui.laydate
                ,$ = layui.$;


        //日期时间选择器
		laydate.render({
		    elem: '#test5'
		    ,type: 'month'
		    ,format: 'MM月'
		});

		//查看当月的统计数据
		$('.month').click(function(){
			var _month = $('input[type="text"]').val();
			if(_month == ''){
				layer.alert('月份不得为空!');
				return false;
			}
		
			$.ajax({
				url:'{{url("/count/month")}}',
				data:{month:_month},
				type:'post',
				dataType:'json',
				headers:{
					'X-CSRF-TOKEN':'{{csrf_token()}}'
				},
				success:function(data){
					$('tbody').html('');
					if(data.code == 1){
						//debugger;
						$('tbody').append(data.error);
					}else if(data.code == 0){
						layer.alert(data.error);
					}
				}
			})
		});

		//查看月内的数据
		$('tbody').on('click','#check',function(){
			var mg_id = $(this).attr('mg-id');
			var month = $(this).attr('month');
			var index =	layer.open({
			      type: 2,
			      title: '月内详情',
			      shadeClose: true,
			      shade: false,
			      maxmin: true, //开启最大化最小化按钮
			      area: ['893px', '600px'],
			      content: '{{url("/count/info")}}'+'/'+mg_id+'/'+month
			    });
			layer.full(index);
		});
		
    });
</script>
@endsection