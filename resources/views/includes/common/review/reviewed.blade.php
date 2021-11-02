@extends('layouts.app')

@section('title')
	Reviewed Audit
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
		<h1>Review Audit <button id="reloadtable" class="btn btn-primary"><i class="fa fa-sync"></i></button></h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('audit.review') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Audit</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
	      <table id="audits" class="table cell-border compact stripe hover display nowrap" width="99%">
		      <thead>
	          <tr>
	            <th scope="col">Status</th>
	            <th scope="col">Location</th>
	            <th scope="col">Audit Item</th>
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
	<script>
		$(document).ready(function () {
			let jotable = $('#audits').DataTable({
		        processing: true,
		        serverSide: true,
		        scrollX: true,
		        columnDefs: [
		          { className: "dt-center", targets: [ 2, 3, 4 ] },
		          { type: 'date', 'targets': [3] }
		        ],
	         	order: [[ 3, 'desc' ]],
		        ajax: "{{ route('audit.reviewed') }}",
		        columns: [
		        		{data: 'stat', name: 'stat'},
		            {data: 'location', name: 'location'},
		            {data: 'item', name: 'item'},
		            {
		               data: 'date_time',
		               name: 'date_time',
		            },
		            {data: 'action', name: 'action', orderable: false, searchable: false},
		        ]
	      });

			$("#reloadtable").click(function () { 
				jotable.ajax.reload();
			});

			// setInterval(function(){
			// 	jotable.ajax.reload();
			// }, 10000);
		});


    $(document).on('click', '#view', function (e) {
        e.preventDefault();
        // var text = $(this).data('text');
        var id = $(this).data('id');
        Swal.fire({
          title: 'View Audit?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'View',
        }).then((result) => {
          if (result.value) {
          	window.location.href = "/audit-review/" + id;
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