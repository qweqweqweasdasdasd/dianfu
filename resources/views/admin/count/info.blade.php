@extends('admin/common/master')
@section('title','月内查看')
@section('class','body')
@section('content')
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
		<tr>
			<th>序号</th>
			<th>当天任务量</th>
			<th>回访数量</th>
			<th>回访人员</th>
			<th>回访时间</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $k=>$v)
		<tr>
			<td>{{++$k}}</td>
			<td>{{$v->f_sum}}</td>
			<td>{{$v->h_sum}}</td>
			<td>{{$manager[$v->mg_id]}}</td>
			<td>{{$v->created_at}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
@section('my-js')

@endsection