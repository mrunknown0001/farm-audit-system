@extends('layouts.app')

@section('title')
	Edit Audit Name
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
		<h1>Edit Audit Name</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('audit.name') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Audit Names</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form id="auditnameform" action="{{ route('audit.name.update', ['id' => $name->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div class="form-group {{ $errors->first('audit_item_name') ? 'has-error' : ''  }}">
						<label for="audit_name">Audit Name</label>
						<input type="text" name="audit_name" id="audit_name" value="{{ $name->category_name }}" placeholder="Audit Name" class="form-control" required>
						@if($errors->first('audit_name'))
            	<span class="help-block"><strong>{{ $errors->first('audit_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea name="description" id="description" class="form-control">{{ $name->description }}</textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div class="form-group">
						<button class="btn btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {

		  $('#auditnameform').on('submit',(function(e) {
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
		          title: 'Audit Name Updated!',
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