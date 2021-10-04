@extends('layouts.app')

@section('title')
	Change Password
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
		<h1>Change Password</h1>
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
				<form action="" method="POST">
					@csrf
					<div class="form-group">
						<label for="current_password">Current Password</label>
						<input type="password" name="current_password" id="current_password" placeholder="Current Password" class="form-control" required="">
					</div>
					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control" required="">
					</div>
					<div class="form-group">
						<label for="new_password_confirmation">Re-Enter New Password</label>
						<input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Re-Enter New Password" class="form-control" required="">
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Change Password</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection