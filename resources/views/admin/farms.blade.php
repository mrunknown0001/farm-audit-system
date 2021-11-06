@extends('layouts.app')

@section('title')
	Farms
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
		<h1>Farms <a href="{{ route('farm.add') }}"><i class="fa fa-plus"></i></a></h1>
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
		      <table id="farms" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">Farm Name</th>
		            <th scope="col">Farm Code</th>
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
			let jotable = $('#farms').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 0, 1, 2 ] }
		        ],
		        ajax: "{{ route('admin.farms') }}",
		        columns: [
		            {data: 'name', name: 'name'},
		            {data: 'code', name: 'code'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});

	    $(document).on('click', '#update', function (e) {
	        e.preventDefault();
	        var id = $(this).data('id');
	        var text = $(this).data('text');
	        Swal.fire({
	          title: 'Update Farm?',
	          text: text,
	          type: 'question',
	          showCancelButton: true,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Continue'
	        }).then((result) => {
	          if (result.value) {
	            // view here
	            window.location.replace("/a/farm/update/" + id);

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