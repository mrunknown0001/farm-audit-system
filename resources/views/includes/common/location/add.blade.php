@extends('layouts.app')

@section('title')
	Add Location
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
		<h1>Add Location</a></h1>
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
				<form id="locationForm" action="{{ route('location.post.add') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div id="LocationNameDiv" class="form-group {{ $errors->first('location_name') ? 'has-error' : ''  }}">
						<label for="location_name">Location Name</label>
						<input type="text" name="location_name" id="location_name" placeholder="Location Name" class="form-control" required>
						@if($errors->first('location_name'))
            	<span class="help-block"><strong>{{ $errors->first('location_name') }}</strong></span>
            @endif
					</div>
					<div id="LocationCodeDiv" class="form-group {{ $errors->first('location_code') ? 'has-error' : ''  }}">
						<label for="location_code">Location Code</label>
						<input type="text" name="location_code" id="location_code" placeholder="Location Code" class="form-control" required>
						@if($errors->first('location_code'))
            	<span class="help-block"><strong>{{ $errors->first('location_code') }}</strong></span>
            @endif
					</div>
					<div id="LocationDescriptionDiv" class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea name="description" id="description" placeholder="Description" class="form-control"></textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div  id="HasSubLocationDiv" class="form-group">
						<input type="checkbox" name="has_sublocation" id="has_sublocation">
						<label for="has_sublocation">Has Sub Location</label>
					</div>
					<div class="form-group">
						<button type="submit" id="locationSubmit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
	$(document).ready(function (e) {
	  $('#locationForm').on('submit',(function(e) {
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
	        // Close Upload Animation here
	        $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Location Added!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	        // Clear Form
	        $("#locationForm").trigger("reset");
	      },
	      error: function(data){
	        console.log("error");
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Try Again.',
					});
		      // Continue validation
					
	      }
	    });
	  }));
	});
	</script>
@endsection