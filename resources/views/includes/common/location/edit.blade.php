@extends('layouts.app')

@section('title')
	Edit Location
@endsection

@section('style')
	<style>
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
		<h1>Edit Location</a></h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('locations') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Locations</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form id="locationForm" action="{{ route('location.update', ['id' => $location->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div id="LocationNameDiv" class="form-group {{ $errors->first('location_name') ? 'has-error' : ''  }}">
						<label for="location_name">Location Name</label>
						<input type="text" name="location_name" id="location_name" value="{{ $location->location_name }}" placeholder="Location Name" class="form-control" required>
						@if($errors->first('location_name'))
            	<span class="help-block"><strong>{{ $errors->first('location_name') }}</strong></span>
            @endif
					</div>
					<div id="LocationCodeDiv" class="form-group {{ $errors->first('location_code') ? 'has-error' : ''  }}">
						<label for="location_code">Location Code</label>
						<input type="text" name="location_code" id="location_code" value="{{ $location->location_code }}" placeholder="Location Code" class="form-control" required>
						@if($errors->first('location_code'))
            	<span class="help-block"><strong>{{ $errors->first('location_code') }}</strong></span>
            @endif
					</div>
					<div id="LocationDescriptionDiv" class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea name="description" id="description" placeholder="Description" class="form-control">{{ $location->description }}</textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div  id="HasSubLocationDiv" class="form-group">
						<input type="checkbox" name="has_sublocation" id="has_sublocation" {{ $location->has_sublocation == 1 ? 'checked' : '' }}>
						<label for="has_sublocation">Has Sub Location</label>
					</div>
					<div  id="ActiveDiv" class="form-group">
						<input type="checkbox" name="active" id="active" {{ $location->active == 1 ? 'checked' : '' }}>
						<label for="active">Active?</label>
					</div>
					@if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
						<div  id="DeletedDiv" class="form-group">
							<input type="checkbox" name="is_deleted" id="is_deleted" {{ $location->is_deleted == 1 ? 'checked' : '' }}>
							<label for="is_deleted">Is Deleted?</label>
						</div>
					@endif
					<div class="form-group">
						<button type="submit" id="locationSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
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
		// Location Form
	  $('#locationForm').on('submit',(function(e) {
	    e.preventDefault();
	    // Remove Warning/Error Messages and Classes
	    $("#LocationNameDiv").removeClass('has-error');
	  	$("#LocationNameDiv span.help-block").remove();
	  	$("#LocationCodeDiv").removeClass('has-error');
	  	$("#LocationCodeDiv span.help-block").remove();
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
	          title: 'Location Updated!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	        // Load Updated Values

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
          // Error Messages
          if(errors.errors['location_name']) {
          	$("#LocationNameDiv").addClass('has-error');
          	$("#LocationNameDiv span.help-block").remove();
          	$("#LocationNameDiv").append("<span class='help-block'><strong>" + errors.errors['location_name'][0] + "</strong></span>");
          }
          if(errors.errors['location_code']) {
          	$("#LocationCodeDiv").addClass('has-error');
          	$("#LocationCodeDiv span.help-block").remove();
          	$("#LocationCodeDiv").append("<span class='help-block'><strong>" + errors.errors['location_code'][0] + "</strong></span>");
          }
	      }
	    });
	  }));

	  $("#location_name").keypress(function () {
	  	$("#LocationNameDiv").removeClass('has-error');
	  	$("#LocationNameDiv span.help-block").remove();
	  });

	  $("#location_code").keypress(function () {
	  	$("#LocationCodeDiv").removeClass('has-error');
	  	$("#LocationCodeDiv span.help-block").remove();
	  });
	});
	</script>
@endsection