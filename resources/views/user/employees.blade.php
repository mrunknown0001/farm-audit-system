@extends('layouts.app')

@section('title')
	Employees
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
		<h1>Employees</h1>
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
		</div>
		<div class="row">
			<div class="col-md-12">
		      <table id="employees" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">First Name</th>
		            <th scope="col">Last Name</th>
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
			let jotable = $('#employees').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0, 1, 2 ] }
		        ],
		        ajax: "{{ route('user.employees') }}",
		        columns: [
		            {data: 'first_name', name: 'first_name'},
		            {data: 'last_name', name: 'last_name'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});
	</script>
@endsection