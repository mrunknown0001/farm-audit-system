@extends('layouts.app')

@section('title')
	Manager Dashboard
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
		<h1>Dashboard</h1>
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
			<div class="col-md-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h3>Employees</h3>
						<p>Employees</p>
					</div>
					<div class="icon">
						<i class="fa fa-users"></i>
					</div>
					<a href="{{ route('user.employees') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>

			<div class="col-md-4">
				<div class="small-box bg-primary">
					<div class="inner">
						<h3>Punches</h3>
						<p>Punches</p>
					</div>
					<div class="icon">
						<i class="fa fa-file"></i>
					</div>
					<a href="{{ route('user.punches') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>

		</div>
	</section>
</div>
@endsection

@section('script')

@endsection