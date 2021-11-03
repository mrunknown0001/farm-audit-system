@extends('layouts.app')

@inject('auditcontroller', '\App\Http\Controllers\AuditController')
@inject('audititemcontroller', '\App\Http\Controllers\AuditItemController')

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
	      background: rgba(255,255,255,0.8) url("/gif/loading-buffering.gif") center no-repeat;
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
					@if($auditcontroller->auditCheck($cat, $dat->id, $l->audit_item->id, 1))
						@if($audititemcontroller->timecheck($l->audit_item->time_range))
							<form class="auditformclass" id="form-{{ $l->id }}" data-id={{ $l->id }} action="{{ route('audit.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="audit_id" id="audit_id-{{ $l->id }}" value="{{ $auditcontroller->auditCheck($cat, $dat->id, $l->audit_item->id, 2) }}">
								<input type="hidden" name="audit_item_id" id="audit_item_id" value="{{ $l->audit_item->id }}">
								<input type="hidden" name="cat" value="{{ $cat }}">
								<input type="hidden" name="dat_id" value="{{ $dat->id }}">
								<input type="hidden" name="done" id="done-{{ $l->id }}" value="0">
								<input type="hidden" class="lat" name="lat" id="latitude-{{ $l->id }}">
								<input type="hidden" class="lon" name="lon" id="longitude-{{ $l->id }}">
								<div class="row">
									<div class="col-md-6 form-group">
										<h3>{{ $l->audit_item->item_name . ' (' . $l->audit_item->time_range . ')' }}</h3>
										<p>{{ $l->audit_item->description }}</p>
										@if(count($l->audit_item->checklists) > 0)
											<ol>
												@foreach($l->audit_item->checklists as $c)
													<li>{{ $c->checklist }}</li>
												@endforeach
											</ol>
										@endif
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label>Compliant ba?</label>
										<select name="compliance" id="compliance-{{ $l->id}}" data-id="{{ $l->id }}" class="compliance form-control" required>
											<option value="n">Pumili ng Isa</option>
											<option value="1">Compliant</option>
											<option value="0">Non-Compliant</option>
										</select>
									</div>
								</div>
								<div class="row" id="noncomplianceremarks-{{ $l->id }}" style="display: none;">
									<div class="col-md-6 form-group">
										<label>Bakit hindi compliant?</label>
										<textarea name="remarks" id="remarks-{{ $l->id }}" class="form-control"></textarea>
									</div>
								</div>

								<div class="row" id="noncompliancecamera-{{ $l->id }}" style="display: none;">
									<div class="col-md-6 form-group text-center">
										<div class="image-upload">
											<input type="file" class="uploadcam" data-id="{{ $l->id }}" id="upload-{{ $l->id }}" name="upload" accept="image/*" capture style="display: none">
											<label for="upload-{{ $l->id }}">
												<span id="camera" class="btn btn-primary"><i class="fa fa-camera fa-3x"></i></span>
											</label>
										</div>
										<p><small>Multiple Image Upload. One at a time capture.</small></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group">
										<label><button type="button" id="btnremark-{{ $l->id }}" data-id={{ $l->id }} class="remarkadd btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Remarks</button></label>
										<textarea name="remark" id="remark-{{ $l->id }}" class="form-control" style="display: none;"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 form-group text-center">
										<button type="submit" id="" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</form>
							<div style="display: none;">{{ $ittirate += 1 }}</div>
						@endif
					@endif
				@endforeach
				<div id="errorcontainer" class="text-center">
					@if($ittirate == 0)
						<h3>No Available Audit Item at the Moment</h3>
						<a href="{{ route('audit.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Return to Audit Page</a> <button type="button" class="btn btn-primary" onclick="location.reload()"><i class="fa fa-sync"></i> Reload</button> 
					@endif
				</div>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>

@endsection

@section('script')
	<script>
		$(document).ready(function (e) {
			getLocation();
			// Form Submittion
		  $('.auditformclass').on('submit',(function(e) {
		    e.preventDefault();
		    getLocation();
		    var formid = $(this).data('id');
		    var latitude = '#latitude-' + formid;
		    var longitude = '#longitude-' + formid;
		    var latitude_coor = $(latitude).val();
		    var longitude_coor = $(longitude).val();
		    if(latitude_coor == '' || latitude_coor == null) {
		    	// Stop form when this error detected
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Reload and Try Again or Allow Location Permission',
					});
					$(this).trigger("reset");
					return false;
		    }
		    var done = "#done-" + formid;
		    $(done).val(1)
	      var uploadid = '#upload-' +formid;
	      $(uploadid).val('');
	      $(uploadid).removeAttr('required');
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
		      	// console.log(formData)
		        // console.log("success");
		        // console.log(data);
		        // Close Upload Animation here
		        $("body").removeClass("loading");
		        Swal.fire({
		          title: 'Audit Submitted!',
		          text: data.message,
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        });

		        var auditid = '#audit_id-' + formid;
		        $(auditid).val(data.id)

		        // remove form once done
		        var frmId = '#form-' + formid;
		        $(frmId).remove(); 

		        // auditformclass if none found display 
		        if ($(".auditformclass").length < 1) {
						   $("#errorcontainer").append('<h3>No Available Audit Item at the Moment</h3> <a href="{{ route("audit.index") }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Return to Audit Page</a> <button type="button" class="btn btn-primary" onclick="location.reload()"><i class="fa fa-sync"></i> Reload</button> ');
						}
		      },
		      error: function(data){
		        // console.log("error");
		        // console.log(data);
		        $("body").removeClass("loading");
			      Swal.fire({
						  type: 'error',
						  title: 'Error Occured',
						  text: data.responseText,
						});
		      }
		    });
		  }));

		});

		$("#viewsupervisors").click(function() {
			var cat = '{{ $cat }}';
	    $.ajax({
	      url: "/auditable/assigned/supervisor/" + cat + "/" + {{ $dat->id }},
	      type: "GET",
	      success: function(data) {
	        // console.log(data);
	        var sup = '<b>Supervisor(s)</b><ul class="">';
	        if(Array.isArray(data) && data.length > 0) {
						var arrayLength = data.length;
						// console.log(arrayLength)
						for (var i = 0; i < arrayLength; i++) {
						  sup += "<li>" + data[i] + "</li>" 
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


		$('.remarkadd').click(function () {
			var id = $(this).data('id');
			var remarkid = '#remark-' + id;
			$(remarkid).show();
		});

    $(document).on('change', '.compliance', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      var complianceid = 'compliance-' +id;
      var value = $(this).val();
      const parentform = document.getElementById(complianceid).form;
      if(value == 0) { 
      	formdatasave(parentform)
      	// show camera upload
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	let remark = '#remarks-' + id;
      	$(noncompliancecamera).show();
      	$(noncomplianceremarks).show();
      	$(upload).attr('required', 'required');
      	$(remark).attr('required', 'required');
      	return true;
      }
      else if(value == 1) {
      	formdatasave(parentform)
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	let remark = '#remarks-' + id;
      	$(noncompliancecamera).hide();
      	$(noncomplianceremarks).hide();
      	$(upload).removeAttr('required');
      	$(remark).removeAttr('required');
      	return true;
      }
      else if(value == 'n') {
      	var noncomplianceremarks = '#noncomplianceremarks-' + id;
      	var noncompliancecamera = '#noncompliancecamera-' + id;
      	let upload = '#upload-' + id;
      	let remark = '#remarks-' + id;
      	$(noncompliancecamera).hide();
      	$(noncomplianceremarks).hide();
      	$(upload).removeAttr('required');
      	$(remark).removeAttr('required');
      	return true;
      }
    });


    $(document).on('change', '.uploadcam', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      var uploadid = 'upload-' +id;
      const parentform = document.getElementById(uploadid).form;
      formdatasave(parentform)
    });


  	function formdatasave(form) {
	    var formid = $(form).data('id');
	    var latitude = '#latitude-' + formid;
	    var longitude = '#longitude-' + formid;
	    var latitude_coor = $(latitude).val();
	    var longitude_coor = $(longitude).val();
	    if(latitude_coor == '' || latitude_coor == null) {
	    	// Stop form when this error detected
	      Swal.fire({
				  type: 'error',
				  title: 'Error Occured',
				  text: 'Please Reload and Try Again or Allow Location Permission',
				});
				return false;
	    }
			// Add Loading Animation here
	  	$("body").addClass("loading"); 
	    var formData = new FormData(form);
	    $.ajax({
	      type:'POST',
	      url: $(form).attr('action'),
	      data:formData,
	      cache:false,
	      contentType: false,
	      processData: false,
	      success:function(data){
	      	// console.log(formData)
	        // console.log("success");
	        // console.log(data);
	        // Close Upload Animation here
	        $("body").removeClass("loading");

	        var auditid = '#audit_id-' + formid;
	        $(auditid).val(data.id)
	      },
	      error: function(data){
	        // console.log("error");
	        // console.log(data);
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: data.responseText,
					});
	      }
	    });
	  }


		var options = {
		  enableHighAccuracy: false,
		  timeout: 30000,
		  maximumAge: 15000
		};

		function getLocation() {
		  if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
		  } else { 
	      console.log('Geolocation Error');
		  }
		}

		function showPosition(position) {
			$('.lon').val(position.coords.longitude);
			$('.lat').val(position.coords.latitude)
			// console.log('Longitude:' + position.coords.longitude);
			// console.log('Latitude:' + position.coords.latitude);
		}

		function showError(error) {
			// Error Show on Sweet Alert
		  switch(error.code) {
		    case error.PERMISSION_DENIED:
		      // x.innerHTML = "User denied the request for Geolocation."
		      console.log("User denied the request for Geolocation.");
		      break;
		    case error.POSITION_UNAVAILABLE:
		      // x.innerHTML = "Location information is unavailable."
		      console.log("Location information is unavailable.");
		      break;
		    case error.TIMEOUT:
		      // x.innerHTML = "The request to get user location timed out."
		      console.log("The request to get user location timed out.");
		      break;
		    case error.UNKNOWN_ERROR:
		      // x.innerHTML = "An unknown error occurred."
		      console.log("An unknown error occurred.");
		      break;
		  }
		}
	</script>
@endsection