@extends('layouts.app')

@section('title')
	Auditable Entity
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
		<h1>Auditable Entity</h1>
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
		      <table id="auditables" class="table cell-border compact stripe hover display nowrap" width="99%">
			      <thead>
		          <tr>
		            <th scope="col">Farm</th>
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
			let jotable = $('#auditables').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        columnDefs: [
          { className: "dt-center", targets: [ 0, 1, 2 ] }
        ],
        ajax: "{{ route('auditables') }}",
        columns: [
            {data: 'farm', name: 'farm'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
	      });
		});
	</script>
@endsection