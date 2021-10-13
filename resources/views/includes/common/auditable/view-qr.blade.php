@extends('layouts.app')

@section('title')
	Auditable View QR
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
		<h1>View QR</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('auditables') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Auditables</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h3>{{ $name }}</h3>
				<img src="{{ asset('/uploads/qr/' . $qrname) }}" alt="{{ $name }}">
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection