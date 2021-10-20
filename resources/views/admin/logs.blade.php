@extends('layouts.app')

@section('title')
	Log Entries
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
		<h1>Log Entries</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><button class="btn btn-primary btn-sm" id="reloadTable"><i class="fas fa-sync-alt"></i> Reload Table</button></p>
				@include('includes.all')
			    <table id="logs" class="display table table-bordered table-striped hover compact nowrap" width="99%">
			      <thead>
			        <tr>
			        	<th>ID</th>
			        	<th>User</th>
			        	<th>User Email</th>
			          <th>Action Made</th>
			          <th>Table</th>
			          <th>New Value</th>
			          <th>Old Value</th>
			          <th>Difference</th>
	              <th>Date and Time Created</th>
			        </tr>
			      </thead>
			      <tbody>
			      </tbody>
			    </table>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
	<script type="text/javascript">
	  $(function () {
	    let table = $('#logs').DataTable({
	      processing: true,
	      serverSide: true,
	      scrollX: true,
				columnDefs: [
					{ className: "dt-center", targets: [ 0, 1, 2, 3, 4 ] }
				],
	      ajax: "{{ route('user.logs') }}",
	      order: [8, 'desc'],
	      columns: [
      		{data: 'id', name : 'id'},
      		{data: 'user', name: 'user'},
      		{data: 'email', name: 'email'},
          {data: 'action', name: 'action'},
          {data: 'table_name', name: 'table_name'},
          {data: 'data1', name: 'data1'},
          {data: 'data2', name: 'data2'},
          {data: 'data3', name: 'data3'},
          {data: 'created_at', name: 'created_at'},
	      ]
	    });
	  });

	  $('#reloadTable').click(function () {
	  	var table = $('#logs').DataTable();
	  	table.ajax.reload();
	  });
	</script>
@endsection