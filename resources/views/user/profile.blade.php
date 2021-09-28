@extends('layouts.app')

@section('title')
	Manager Profile
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
		<h1>Profile</h1>
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
				<h3>My Information</h3>
				<p>Firt Name: <b>{{ Auth::user()->first_name }}</b></p>
				<p>Last Name: <b>{{ Auth::user()->last_name }}</b></p>
				<p>Email: <b>{{ Auth::user()->email }}</b></p>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection