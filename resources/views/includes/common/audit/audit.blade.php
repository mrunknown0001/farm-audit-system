@extends('layouts.app')

@section('title')
	Audit
@endsection

@section('style')
	<style type="text/css">
		ul {
			list-style-type: none;
		}
	</style>
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
		<h1>Auditable Location: <strong>{{ $cat == 'loc' ? $dat->location_name : $dat->sub_location_name }}</strong></h1>
		{{-- <ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol> --}}
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div><button id="viewsupervisors" class="btn btn-link">View Supervisor(s)</button> <button id="viewcaretakers" class="btn btn-link">View Caretaker(s)</button></div>
				<div id="supDiv" style="display: none;"></div>
				<div id="caretakerDiv" style="display: none;"></div>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">

			</div>
		</div>
	</section>
</div>

@endsection

@section('script')
	<script>
		$("#viewsupervisors").click(function() {
			var cat = '{{ $cat }}';
	    $.ajax({
	      url: "/auditable/assigned/supervisor/" + cat + "/" + {{ $dat->id }},
	      type: "GET",
	      success: function(data) {
	        // console.log(data);
	        var sup = '<b>Supervisor(s)</b><ul class="">';
					var arrayLength = data.length;
					// console.log(arrayLength)
					for (var i = 0; i < arrayLength; i++) {
					  sup += "<li>" + data[i].name + "</li>" 
					}
					sup += "</ul>";
	        $('#supDiv').html(sup);
	        $('#supDiv').show();
	      },
	      error: function(err) {
	      	// console.log(err.responseJSON)
	        Swal.fire({
	          title: 'Error Occured! Tray Again Later.',
	          text: "Try again getting Supervisor(s) Assigned",
	          type: 'error',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	      }
	    });
		});

		$("#viewcaretakers").click(function() {
			var cat = '{{ $cat }}';
	    $.ajax({
	      url: "/auditable/assigned/caretaker/" + cat + "/" + {{ $dat->id }},
	      type: "GET",
	      success: function(data) {
	        // console.log(data);
	        var ct = '<b>Caretaker(s)</b><ul class="">';
					var arrayLength = data.length;
					// console.log(arrayLength)
					for (var i = 0; i < arrayLength; i++) {
					  ct += "<li>" + data[i].name + "</li>" 
					}
					ct += "</ul>";
	        $('#caretakerDiv').html(ct);
	        $('#caretakerDiv').show();
	      },
	      error: function(err) {
	      	// console.log(err.responseJSON)
	        Swal.fire({
	          title: 'Error Occured! Tray Again Later.',
	          text: "Try again getting Caretaker(s) Assigned",
	          type: 'error',
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