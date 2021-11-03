@extends('layouts.app')

@section('title')
	System Configuration
@endsection

@section('style')

@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>System Configuration</h1>
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
			<div class="col-md-6 col-md-offset-3">
				<form id="configForm" action="{{ route('system.config.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="system_name">System Name</label>
						<input type="text" id="system_name" name="system_name" class="form-control" value="{{ $system->system_name }}" required="">
					</div>
					<div class="form-group">
						<label for="system_title_suffix">System Title Suffix</label>
						<input type="text" id="system_title_suffix" name="system_title_suffix" class="form-control" value="{{ $system->system_title_suffix }}" required="">
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function () {
		// Location Form
	  $('#configForm').on('submit',(function(e) {
	    e.preventDefault();
			// Add Loading Animation here
	  	// $("body").addClass("loading"); 
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
	        // $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Config Updated!',
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
	      }
	    });
	  }));
	});
</script>
@endsection