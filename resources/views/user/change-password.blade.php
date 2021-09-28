@extends('layouts.app')

@section('title')
	Change Password
@endsection

@section('style')

@endsection

@section('header')
	@include('user.includes.header')
@endsection

@section('sidebar')
	@include('user.includes.sidebar')
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
				<form action="{{ route('user.post.change.password') }}" method="POST">
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