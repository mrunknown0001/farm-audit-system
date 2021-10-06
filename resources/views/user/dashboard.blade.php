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
				<button id="start-camera">Start Camera</button>
				<video id="video" width="100%" height="auto" autoplay></video>
				<button id="click-photo">Click Photo</button>
				<canvas class="img img-responsive" id="canvas"></canvas>
			</div>		
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
		let camera_button = document.querySelector("#start-camera");
		let video = document.querySelector("#video");
		let click_button = document.querySelector("#click-photo");
		let canvas = document.querySelector("#canvas");

		camera_button.addEventListener('click', async function() {
			let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
			video.srcObject = stream;
	    let constraints = { 
	          audio: false, 
	          video: { 
	            width: { ideal: 1920 }, 
	            height: { ideal: 1080 }  
	          }
          };
	    let stream_settings = stream.getVideoTracks()[0].getSettings();
	    let stream_width = stream_settings.width;
	    let stream_height = stream_settings.height;

	    console.log('Width: ' + stream_width + 'px');
	    console.log('Height: ' + stream_height + 'px');

	    // set height and width of image
	    $("#canvas").height(stream_height + 'px');
	    $("#canvas").width(stream_width + 'px');
		});

		click_button.addEventListener('click', function() {
	   	canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
	   	let image_data_url = canvas.toDataURL('image/jpeg');
	   	
	   	// data url of the image
	   	console.log(image_data_url);
		});



	</script>
@endsection