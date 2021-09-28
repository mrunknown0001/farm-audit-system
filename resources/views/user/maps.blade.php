@extends('layouts.app')

@section('title')
	Maps
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
		<h1>Maps</h1>
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
			<div id="mapholder"></div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function () {
			var latlon = {{ $lat }} + "," + {{ $lon }};
			var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw";

			document.getElementById("mapholder").innerHTML = "<img class='img img-responsive' src='"+img_url+"'>";
		});
	</script>
@endsection