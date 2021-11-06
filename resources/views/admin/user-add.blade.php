@extends('layouts.app')

@section('title')
	Add User
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

@section('header')
	@include('admin.includes.header')
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Add User</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('admin.users') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Users List</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h3>User Detail</h3>
				<form id="userForm" action="{{ route('admin.post.add.user') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" placeholder="First Name" class="form-control" name="first_name" id="first_name" required>
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" placeholder="Last Name" class="form-control" name="last_name" id="last_name" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" placeholder="Email" class="form-control" name="email" id="email" required>
					</div>
					<div class="form-group">
						<label for="role">Role</label>
						<select class="form-control" id="role" name="role" required>
							<option value="">Select Role</option>
							@foreach($roles as $key => $r)
								<option value="{{ $r->id }}">{{ $r->name }}</option>
							@endforeach
						</select>
					</div>
					{{-- <div class="form-group">
						<label for="farm">Farm</label>
						<select class="form-control" id="farm" name="farm" required>
							<option value="">Select Farm</option>
							@foreach($farms as $key => $r)
								<option value="{{ $r->id }}">{{ $r->name }}</option>
							@endforeach
						</select>
					</div> --}}
					<div class="form-group">
						<label for="password">Password</label>
						<input type="text" placeholder="Password" class="form-control" name="password" id="password" required>
					</div>
					<div class="form-group">
						<h3>Farms</h3>
						@if(count($farms) > 0)
							<div class="row">
								@foreach($farms as $key => $f)
									<div class="col-md-12"><input type="checkbox" name="farms[]" id="farm{{ $f->id }}" value="{{ $f->id }}"> <label for="farm{{ $f->id }}">{{ $f->name }}</label></div>
								@endforeach
							</div>
						@else
							<p>No Farm Available</p>
						@endif
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Save</button>
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
			$('#userForm').on('submit',(function(e) {
		    e.preventDefault();
		    var formData = new FormData(this);
		    $.ajax({
		      type:'POST',
		      url: $(this).attr('action'),
		      data:formData,
		      cache:false,
		      contentType: false,
		      processData: false,
		      beforSend: function() {
				  	$("body").addClass("loading"); 
		      },
		      success:function(data){
		        console.log("success");
		        Swal.fire({
		          title: 'User Added!',
		          text: "",
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        });
		        $("#userForm").trigger("reset");
		      },
		      error: function(data){
		        console.log(data);
		        $("body").removeClass("loading");
			      Swal.fire({
						  type: 'error',
						  title: 'Error Occured',
						  text: 'Please Try Again.',
						});
						return false;
		      },
		      complete: function() {
		      	// Clear Form
		        $("body").removeClass("loading");
		      }
		    });
		  }));
		});
		  
	</script>
@endsection