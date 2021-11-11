@extends('layouts.app')

@section('title')
	Edit Sub Location
@endsection

@section('style')

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
		<h1>Edit Sub Location</a></h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('sub.locations') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Sub Locations</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form id="SubLocationForm" action="{{ route('sub.location.update', ['id' => $sublocation->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div id="LocationNameDiv" class="form-group {{ $errors->first('location_name') ? 'has-error' : ''  }}">
						<label for="location_name">Location Name</label>
						<select name="location_name" id="location_name" class="form-control" required>
							<option value="">Select Location Name</option>
							@foreach($locations as $key => $l)
								<option value="{{ $l->id }}" {{ $sublocation->location_id == $l->id ? 'selected' : '' }}>{{ $l->farm->code . '-' . $l->location_name }}</option>
							@endforeach
						</select>
						@if($errors->first('location_name'))
            	<span class="help-block"><strong>{{ $errors->first('location_name') }}</strong></span>
            @endif
					</div>
					<div id="SubLocationNameDiv" class="form-group {{ $errors->first('sub_location_name') ? 'has-error' : ''  }}">
						<label for="sub_location_name">Sub Location Name</label>
						<input type="text" name="sub_location_name" id="sub_location_name" value="{{ $sublocation->sub_location_name }}"  placeholder="Sub Location Name" class="form-control" required>
						@if($errors->first('sub_location_name'))
            	<span class="help-block"><strong>{{ $errors->first('sub_location_name') }}</strong></span>
            @endif
					</div>
					<div id="SubLocationCodeDiv" class="form-group {{ $errors->first('sub_location_code') ? 'has-error' : ''  }}">
						<label for="sub_location_code">Sub Location Code</label>
						<input type="text" name="sub_location_code" id="sub_location_code" value="{{ $sublocation->sub_location_code }}" placeholder="Sub Location Code" class="form-control" required>
						@if($errors->first('sub_location_code'))
            	<span class="help-block"><strong>{{ $errors->first('sub_location_code') }}</strong></span>
            @endif
					</div>
					<div id="SubLocationDescriptionDiv" class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea name="description" id="description" placeholder="Description" class="form-control">{{ $sublocation->description }}</textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div  id="ActiveDiv" class="form-group">
						<input type="checkbox" name="active" id="active" {{ $sublocation->active == 1 ? 'checked' : '' }}>
						<label for="active">Active?</label>
					</div>
					@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
						<div  id="DeletedDiv" class="form-group">
							<input type="checkbox" name="is_deleted" id="is_deleted" {{ $sublocation->is_deleted == 1 ? 'checked' : '' }}>
							<label for="is_deleted">Is Deleted?</label>
						</div>
					@endif
					<div class="form-group">
						<button type="submit" id="SubLocationSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script>
	$(document).ready(function () {
		// Sub Location Form
	  $('#SubLocationForm').on('submit',(function(e) {
	    e.preventDefault();
	    // Remove Warning/Error Messages and Classes
	    $("#LocationNameDiv").removeClass('has-error');
	  	$("#LocationNameDiv span.help-block").remove();
	    $("#SubLocationNameDiv").removeClass('has-error');
	  	$("#SubLocationNameDiv span.help-block").remove();
	  	$("#SubLocationCodeDiv").removeClass('has-error');
	  	$("#SubLocationCodeDiv span.help-block").remove();
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
	        // Close Upload Animation here
	        $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Sub Location Updated!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	      },
	      error: function(data){
	        console.log("error");
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Try Again.',
					});

					var errors = data.responseJSON;
					console.log(errors);
          // Error Messages
          if(errors.errors['location_name']) {
          	$("#LocationNameDiv").addClass('has-error');
          	$("#LocationNameDiv span.help-block").remove();
          	$("#LocationNameDiv").append("<span class='help-block'><strong>" + errors.errors['location_name'][0] + "</strong></span>");
          }
          if(errors.errors['sub_location_code']) {
          	$("#SubLocationCodeDiv").addClass('has-error');
          	$("#SubLocationCodeDiv span.help-block").remove();
          	$("#SubLocationCodeDiv").append("<span class='help-block'><strong>" + errors.errors['sub_location_code'][0] + "</strong></span>");
          }
          if(errors.errors['sub_location_name']) {
          	$("#SubLocationNameDiv").addClass('has-error');
          	$("#SubLocationNameDiv span.help-block").remove();
          	$("#SubLocationNameDiv").append("<span class='help-block'><strong>" + errors.errors['sub_location_name'][0] + "</strong></span>");
          }
	      }
	    });
	  }));

	  $("#location_name").change(function () {
	  	$("#LocationNameDiv").removeClass('has-error');
	  	$("#LocationNameDiv span.help-block").remove();
	  });

	  $("#sub_location_name").keypress(function () {
	  	$("#SubLocationNameDiv").removeClass('has-error');
	  	$("#SubLocationNameDiv span.help-block").remove();
	  });

	  $("#sub_location_code").keypress(function () {
	  	$("#SubLocationCodeDiv").removeClass('has-error');
	  	$("#SubLocationCodeDiv span.help-block").remove();
	  });
	});
	</script>
@endsection