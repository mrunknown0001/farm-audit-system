@extends('layouts.app')

@section('title')
	Review Audit
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
		<h1>Review</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('audit.review') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Audit</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h2>Location: <strong>{{ $audit->field1 == 'loc' ? $audit->location->location_name : $audit->sub_location->location->location_name . ' - ' . $audit->sub_location->sub_location_name }}</strong></h2>
				@if($audit->compliance == 1) 
					<p><span class="label label-success">COMPLIANT <i class="fa fa-check"></i></span></p>
				@else
					<p><span class="label label-danger">NON-COMPLIANT <i class="fa fa-close"></i></span></p>
				@endif
				<p><a href=""><i class="fa fa-map-marked-alt"></i> View Location</a></p>
				<p>Timestamp: {{ $audit->created_at }}</p>
				<hr>
				<p>Audit Item: <strong>{{ $audit->audit_item->item_name . ' (' . $audit->audit_item->time_range . ')' }}</strong></p>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection