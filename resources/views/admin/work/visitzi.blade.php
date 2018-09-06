@extends('admin.common.master')
@section('title','详情页面')
@section('class','body')
@section('content')
<table class="layui-table" lay-even lay-skin="line">
	<colgroup>
		<col >
		<col >
		<col >
		<col width="80">
		<col width="150">
	</colgroup>
	<thead>
		<tr>
			<th>ID</th>
			<th>回访目的</th>
			<th>回访内容</th>
			<th>操作者</th>
			<th>回访时间</th>
		</tr>
	</thead>
	<tbody>
		@foreach($jobs as $job)
		@foreach($job->visit as $visit)
		<tr>
			<td>{{$job->u_id}}</td>
			<td>{{$visit->title}}</td>
			<td>{{$visit->content}}</td>
			<td>{{$manager[$job->mg_id]}}</td>
			<td>{{$visit->created_at}}</td>
		</tr>
		@endforeach
		@endforeach
	</tbody>
</table>
@endsection
@section('my-js')
@endsection