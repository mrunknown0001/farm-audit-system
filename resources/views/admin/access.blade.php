@extends('layouts.app')

@section('title')
	Access List
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Access List</h1>
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
		      <table id="access" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">Name</th>
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
	<script src="{{ asset('js/dataTables.js') }}" defer="defer"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}" defer="defer"></script>
	<script>
		$(document).ready(function () {
			let jotable = $('#access').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0 ] }
		        ],
		        ajax: "{{ route('access') }}",
		        columns: [
		            {data: 'name', name: 'name'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});

	</script>
@endsection