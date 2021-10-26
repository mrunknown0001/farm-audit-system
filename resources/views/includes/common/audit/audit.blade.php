@extends('layouts.app')

@section('title')
	Audit
@endsection

@section('style')
	<style type="text/css">
		ul {
			list-style-type: none;
		}
		.image-upload > input
		{
			display: none;
		}

		.image-upload i
		{
		  cursor: pointer;
		}

	  .overlay{
	      display: none;
	      position: fixed;
	      width: 100%;
	      height: 100%;
	      top: 0;
	      left: 0;
	      z-index: 999;
	      background: rgba(255,255,255,0.8) url("/gif/apple.gif") center no-repeat;
	  }
	  body.loading{
	      overflow: hidden;   
	  }
	  body.loading .overlay{
	      display: block;
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
		<h1>Auditable Location: <strong>{{ $cat == 'loc' ? $dat->location_name : $dat->location->location_name . ' - ' . $dat->sub_location_name }}</strong></h1>
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
				@foreach($audit_locs as $key => $l)
					<form id="auditform" data-id={{ $l->id }} action="{{ route('audit.store') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="audit_id" id="audit_id" value="">
						<input type="hidden" name="audit_item_id" id="audit_item_id" value="{{ $l->audit_item->id }}">
						<input type="hidden" name="cat" value="{{ $cat }}">
						<input type="hidden" name="dat_id" value="{{ $dat->id }}">
						<input type="hidden" name="lat" id="lat" value="">
						<input type="hidden" name="lon" id="lon" value="">
						<h3>{{ $l->audit_item->item_name . '(' . $l->audit_item->time_range . ')' }}</h3>
						<p>{{ $l->audit_item->description }}</p>
						<div class="row">
							<div class="col-md-6 form-group">
								<label>Compliant ba?</label>
								<select name="compliance" id="compliance" data-id="{{ $l->id }}" class="form-control" required>
									<option value="">Pumili ng Isa</option>
									<option value="1">Compliant</option>
									<option value="0">Non-Compliant</option>
								</select>
							</div>
						</div>
						<div class="row" id="noncomplianceremarks-{{ $l->id }}" style="display: none;">
							<div class="col-md-6 form-group">
								<label>Bakit hindi compliance?</label>
								<textarea name="remarks" id="remarks" class="form-control"></textarea>
							</div>
						</div>

						<div class="row" id="noncompliancecamera-{{ $l->id }}" style="display: none;">
							<div class="col-md-6 form-group text-center">
								<div class="image-upload">
									<input type="file" id="upload-{{ $l->id }}" name="upload" accept="image/*" capture style="display: none">
									<label for="upload-{{ $l->id }}">
										<span id="camera" class="btn btn-primary"><i class="fa fa-camera fa-3x"></i></span>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 form-group text-center">
								<button type="submit" id="" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</form>
				@endforeach
			</div>
		</div>
		<div class="overlay"></div>
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
	        if(Array.isArray(data)) {
						var arrayLength = data.length;
						// console.log(arrayLength)
						for (var i = 0; i < arrayLength; i++) {
						  sup += "<li>" + data[i].name + "</li>" 
						}
	        }
	        else {
	        	sup += "<li>" + data + "</li>";
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
	        if(Array.isArray(data)) {
						var arrayLength = data.length;
						// console.log(arrayLength)
						for (var i = 0; i < arrayLength; i++) {
						  ct += "<li>" + data[i].name + "</li>" 
						}
	        }
	        else {
	        	ct += "<li>" + data + "</li>";
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

    $(document).on('change', '#compliance', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      var value = $(this).val();
      if(value == 0) {
      	// show camera upload
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	$(noncompliancecamera).show();
      	$(noncomplianceremarks).show();
      	$(upload).attr('required');
      }
      else if(value == null) {
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	$(noncompliancecamera).hide();
      	$(noncomplianceremarks).hide();
      	$(upload).removeAttr('required');
      }
      else {
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	$(noncompliancecamera).hide();
      	$(noncomplianceremarks).hide();
      	$(upload).removeAttr('required');
      }
    });

		$(document).ready(function (e) {
			var formid = $(this).data('id');
			getLocation();
		  $('#auditform').on('submit',(function(e) {
		    e.preventDefault();
				// Add Loading Animation here
		  	$("body").addClass("loading"); 
		    var formData = new FormData(this);
		    $.ajax({
		      type:'POST',
		      url: $(this).attr('action'),
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      success:function(data){
		        console.log("success");
		        console.log(data);
		        // Close Upload Animation here
		        $("body").removeClass("loading");
		        Swal.fire({
		          title: 'Audit Submitted!',
		          text: "",
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        });
		        // remove
		        $("#auditform").remove(); 
		      },
		      error: function(data){
		        console.log("error");
		        console.log(data.responseJSON);
		        $("body").removeClass("loading");
			      Swal.fire({
						  type: 'error',
						  title: 'Error Occured',
						  text: 'Please Try Again.',
						});
		      }
		    });
		  }));

		});



		var options = {
		  enableHighAccuracy: true,
		  timeout: 10000,
		  maximumAge: 10000
		};

		function getLocation() {
		  if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
		  } else { 
	      Swal.fire({
				  type: 'error',
				  title: 'Geolocation Error',
				  text: 'Geolocation is not supported by this browser.',
				  // footer: '<a href="">Why do I have this issue?</a>'
				})
		  }
		}

		function showPosition(position) {
		  console.log('Latitude:' + position.coords.latitude);
		  console.log('Longitude:' + position.coords.longitude);
		  $('#lat').val(position.coords.latitude);
		  $('#lon').val(position.coords.longitude);
		}

		function showError(error) {
			// Error Show on Sweet Alert
		  switch(error.code) {
		    case error.PERMISSION_DENIED:
		      // x.innerHTML = "User denied the request for Geolocation."
		      console.log("User denied the request for Geolocation.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Permission Denied',
					  text: 'User denied the request for Geolocation.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					})
		      break;
		    case error.POSITION_UNAVAILABLE:
		      // x.innerHTML = "Location information is unavailable."
		      console.log("Location information is unavailable.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Position Unavailable',
					  text: 'Location information is unavailable.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					});
		      break;
		    case error.TIMEOUT:
		      // x.innerHTML = "The request to get user location timed out."
		      console.log("The request to get user location timed out.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Timeout Error',
					  text: 'The request to get user location timed out.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					})
		      break;
		    case error.UNKNOWN_ERROR:
		      // x.innerHTML = "An unknown error occurred."
		      console.log("An unknown error occurred.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Unknown Error',
					  text: 'An unknown error occurred.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					});
		      break;
		  }
		}
	</script>
@endsection