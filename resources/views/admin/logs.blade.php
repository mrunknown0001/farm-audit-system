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
			          <th>Record ID</th>
			          <th>New Value</th>
			          <th>Old Value</th>
			          <th>Device</th>
			          <th>MAC Address</th>
			          <th>IP Address</th>
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
					{ className: "dt-center", targets: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ] }
				],
	      ajax: "{{ route('admin.show.log.entries') }}",
	      order: [11, 'desc'],
	      columns: [
      		{data: 'id', name : 'id'},
      		{data: 'name', name: 'name'},
      		{data: 'email', name: 'email'},
          {data: 'action', name: 'action'},
          {data: 'table_name', name: 'table_name'},
          {data: 'record_id', name: 'record_id'},
          {data: 'new_val', name: 'new_val'},
          {data: 'old_val', name: 'old_val'},
          {data: 'device', name: 'device'},
          {data: 'mac', name: 'mac_address'},
          {data: 'ip1', name: 'ip1'},
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