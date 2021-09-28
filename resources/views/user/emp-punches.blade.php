@extends('layouts.app')

@section('title')
	{{ $emp->first_name . ' ' . $emp->last_name }} - Punches
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('header')
	@include('user.includes.header')
@endsection

@section('sidebar')
	@include('user.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>{{ $emp->first_name . ' ' . $emp->last_name }} - Punches</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('user.employees') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Employee List</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
		      <table id="punches" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">Type</th>
		            <th scope="col">Date & Time</th>
		            <th scope="col">UUID</th>
		            <th scope="col">IP</th>
		            <th scope="col">Action</th>
		          </tr>
		        </thead>
		      </table>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('js/sweetalert.js') }}"></script>

	<script>
		$(document).ready(function () {
			let jotable = $('#punches').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0, 1, 2, 3, 4 ] }
		        ],
		        ajax: "{{ route('user.show.emp.log', $emp->id) }}",
		        columns: [
	            {data: 'type', name: 'type'},
	            {data: 'date_time', name: 'date_time'},
	            {data: 'uuid', name: 'uuid'},
	            {data: 'ip', name: 'ip'},
	            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});
	</script>
@endsection