@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('style')

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
			<div class="col-md-6">
				<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="file" id="upload" name="upload" accept="image/*" capture>
					<br>
					<button type="submit">Up</button>
				</form>
			</div>		
		</div>
		<div class="row">
			<div class="col-md-6">
				@foreach($uploads as $key => $u)
					<p><a href="/uploads/test/{{ $u->filename }}">{{ $u->filename }}</a></p>
				@endforeach
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection