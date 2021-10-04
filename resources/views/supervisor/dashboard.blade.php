@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('style')

@endsection

@section('sidebar')
	@include('supervisor.includes.sidebar')
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

		</div>
	</section>
</div>
@endsection

@section('script')

@endsection