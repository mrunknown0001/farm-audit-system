@extends('layouts.app')

@section('title')
	Set User Access
@endsection

@section('style')

@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Set User Access</h1>
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
			<div class="col-md-12">
				<h4>User: {{ $user->first_name . ' ' . $user->last_name }}</h4>
				<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
					<div class="form-group">
						<h4>Location</h4>
						<ul class="list-inline">
							<li><input type="checkbox" name="location_add" id="location_add"> <label for="location_add">Add</label></li>
							<li><input type="checkbox"> Edit</li>
							<li><input type="checkbox"> Delete</li>
						</ul>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection