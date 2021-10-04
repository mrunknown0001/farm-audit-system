@extends('layouts.app')

@section('title')
	My Punches
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('header')
	@include('employee.includes.header')
@endsection

@section('sidebar')
	@include('employee.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Dashboard</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				@include('includes.all')
			</div>
			<div class="col-md-12">
		      <table id="punches" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">Type</th>
		            <th scope="col">Date & Time</th>
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
		          { className: "dt-center", targets: [ 0, 1, 2 ] }
		        ],
		        ajax: "{{ route('emp.punches') }}",
		        columns: [
		            {data: 'type', name: 'type'},
		            {data: 'date_time', name: 'date_time'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});
	</script>
@endsection