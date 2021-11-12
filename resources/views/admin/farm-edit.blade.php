@extends('layouts.app')

@section('title')
	Edit Farm
@endsection

@section('style')

@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Edit Farm</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('admin.farms') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Farms</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form id="farmaddform" action="{{ route('farm.update', ['id' => $farm->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" name="id" value="{{ $farm->id }}">
					<div class="form-group {{ $errors->first('farm_name') ? 'has-error' : ''  }}">
						<label for="farm_name">Farm Name</label>
						<input type="text" name="farm_name" id="farm_name" placeholder="Farm Name" value="{{ $farm->name }}" class="form-control" required>
						@if($errors->first('farm_name'))
            	<span class="help-block"><strong>{{ $errors->first('farm_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('farm_code') ? 'has-error' : ''  }}">
						<label for="farm_code">Farm Code</label>
						<input type="text" name="farm_code" id="farm_code" placeholder="Farm Code" value="{{ $farm->code }}" class="form-control" required>
						@if($errors->first('farm_code'))
            	<span class="help-block"><strong>{{ $errors->first('farm_code') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea name="description" id="description" class="form-control">{{ $farm->description }}</textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div class="form-group">
						<input type="checkbox" name="active" id="active" value="1" {{ $farm->active ? 'checked' : '' }}>
						<label for="active">Active?</label>
					</div>
					<div class="form-group">
						<button class="btn btn-success">Submit</button>
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
		$(document).ready(function() {

		  $('#farmaddform').on('submit',(function(e) {
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
		        // console.log("success");
		        // console.log(data);
		        // Close Upload Animation here
		        $("body").removeClass("loading");
		        Swal.fire({
		          title: 'Farm Updated!',
		          text: "",
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        });
		      },
		      error: function(data){
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
	</script>
@endsection