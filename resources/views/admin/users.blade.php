@extends('layouts.app')

@section('title')
	Users
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('header')
	@include('admin.includes.header')
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Users <a href="{{ route('admin.add.user') }}"><i class="fa fa-plus"></i></a></h1>
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
		      <table id="users" class="table cell-border compact stripe hover" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">First Name</th>
		            <th scope="col">Last Name</th>
		            <th scope="col">Type</th>
		            <th scope="col">Status</th>
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
			let jotable = $('#users').DataTable({
		        processing: true,
		        serverSide: true,
		         scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0, 1, 2, 3, 4 ] }
		        ],
		        ajax: "{{ route('admin.users') }}",
		        columns: [
		            {data: 'first_name', name: 'first_name'},
		            {data: 'last_name', name: 'last_name'},
		            {data: 'type', name: 'type'},
		            {data: 'active', name: 'active'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});

	    $(document).on('click', '#updateuser', function (e) {
	        e.preventDefault();
	        var id = $(this).data('id');
	        var text = $(this).data('text');
	        Swal.fire({
	          title: 'Update User?',
	          text: text,
	          type: 'question',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Continue'
	        }).then((result) => {
	          if (result.value) {
	            // view here
	            window.location.replace("/a/user/update/" + id);

	          }
	          else {
	            Swal.fire({
	              title: 'Action Cancelled',
	              text: "",
	              type: 'info',
	              showCancelButton: false,
	              confirmButtonColor: '#3085d6',
	              cancelButtonColor: '#d33',
	              confirmButtonText: 'Close'
	            });
	          }
	        });
	    });
	</script>
@endsection