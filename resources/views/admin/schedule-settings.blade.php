@extends('layouts.app')

@section('title')
	Schedule Settings
@endsection

@section('style')

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
		<h1>Schedule Settings</h1>
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
				<h3>Time</h3>
				<form action="{{ route('update.schedule') }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="time_in">Time In</label>
						<input type="text" value="{{ $sched->timein }}" class="form-control" name="time_in" id="time_in" required>
					</div>
					<div class="form-group">
						<label for="time_out">Time Out</label>
						<input type="text" value="{{ $sched->timeout }}" class="form-control" name="time_out" id="time_out" required="">
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection