@extends('layouts.app')

@section('title')
	Audit Name
@endsection

@section('style')
  <link href="{{ asset('datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('sidebar')
	@if(Auth::User()->role_id == 2 || Auth::User()->role_id == 1)
		@include('admin.includes.sidebar')
	@elseif(Auth::User()->role_id == 3)
		@include('vp.includes.sidebar')
	@elseif(Auth::User()->role_id == 4)
		@include('divhead.includes.sidebar')
	@elseif(Auth::User()->role_id == 5)
		@include('manager.includes.sidebar')
	@elseif(Auth::User()->role_id == 6)
		@include('supervisor.includes.sidebar')
	@elseif(Auth::User()->role_id == 7)
		@include('officer.includes.sidebar')
	@elseif(Auth::User()->role_id == 8)
		@include('user.includes.sidebar')
	@endif
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Audit Name <a href="{{ route('audit.name.add') }}"><i class="fa fa-plus"></i></a></h1>
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
	      <table id="items" class="table cell-border compact stripe hover display nowrap" width="99%">
		      <thead>
	          <tr>
	            <th scope="col">Audit Name</th>
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
			let datatable = $('#items').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 1 ] }
		        ],
		        ajax: "{{ route('audit.name') }}",
		        columns: [
		            {data: 'name', name: 'name'},
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });
		});

    $(document).on('click', '#edit', function (e) {
        e.preventDefault();
        // var text = $(this).data('text');
        var id = $(this).data('id');
        Swal.fire({
          title: 'Edit Audit Name?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Edit',
        }).then((result) => {
          if (result.value) {
          	window.location.href = "/audit-name/edit/" + id;
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

    $(document).on('click', '#remove', function (e) {
        e.preventDefault();
        // var text = $(this).data('text');
        var id = $(this).data('id');
        Swal.fire({
          title: 'Remove Audit Name?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Remove',
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url: "/audit-name/remove/" + id,
              type: "GET",
              success: function() {
                Swal.fire({
                  title: 'Audit Name Removed!',
                  text: "",
                  type: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Close'
                });

                var table = $('#items').DataTable();
                table.ajax.reload();
              },
              error: function(err) {

                Swal.fire({
                  title: 'Error Occured! Tray Again Later.',
                  text: "",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Close'
                });
              }
            });
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