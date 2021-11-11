@extends('layouts.app')

@section('title')
	Marshal Reports
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
		<h1>Marshal Reports</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('reports') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Reports</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="{{ route('report.post.export.marshal') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="farm">Select Farm</label>
						<select name="farm" id="farm" class="form-control" required>
							<option value="">Select Farm</option>
							@foreach($farms as $key => $f)
								<option value="{{ $f->farm->id }}">{{ $f->farm->code }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="from">From Date</label>
								<input type="date" name="from" id="from" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label for="to">To Date</label>
								<input type="date" name="to" id="to" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-danger"><i class="fa fa-file-export"></i> Export</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection