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
			<div class="col-md-12">
				<p>Employee: <b>{{ $log->employee->first_name . ' ' . $log->employee->last_name }}</b></p>
				<p>Date and Time: <b>{{ date('F j, Y h:i:s A', strtotime($log->created_at)) }}</b></p>
				<div id="mapholder" style="border: 1px solid grey"></div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw"></script>
	<script>
		$(document).ready(function () {

			var lat = {{ $lat }};
			var lon = {{ $lon }};
			// var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw";
		  var latlon=new google.maps.LatLng(lat, lon)
		  var mapholder=document.getElementById('mapholder')
		  mapholder.style.height='250px';
		  mapholder.style.width='100%';

		  var myOptions={
		  center:latlon,zoom:14,
		  mapTypeId:google.maps.MapTypeId.ROADMAP,
		  mapTypeControl:false,
		  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
		  };
		  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
		  var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});


		});
	</script>
@endsection