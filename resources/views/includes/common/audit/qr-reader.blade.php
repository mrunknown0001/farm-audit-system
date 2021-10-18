@extends('layouts.app')

@section('title')
	QR Reader
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
		<h1>QR Reader</h1>
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
			<div class="col-md-12 text-center">
				<video id="preview" class="p-1 border" style="width:80%;"></video>
				<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
				  <button class="btn btn-success" id="startcamera">
				  	<i class="fa fa-play-circle"></i>
				  </button>
				  <label class="btn btn-primary active">
					<input type="radio" name="options" value="1" autocomplete="off" checked><i class="fa fa-sync"></i> Front Camera
				  </label>
				  <label class="btn btn-warning">
					<input type="radio" name="options" value="2" autocomplete="off"><i class="fa fa-camera"></i> Back Camera
				  </label>
				  <button class="btn btn-danger" id="stopcamera">
				  	<i class="fa fa-stop-circle"></i>
				  </button>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	{{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
	<script src="{{ asset('js/instascan.js') }}"></script>
	<script type="text/javascript">
		let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
		scanner.addListener('scan',function(content){
			// Validation
			// alert(content);
			
			if(isUrl(content)) {
				var pathArray = content.split("/");
				var host = window.location.host;
				if(pathArray[1] == host) {
					alert('path1' . pathArray[1])
					window.location.href = content;
				}
				else {
					alert(content)
	        Swal.fire({
	          title: 'Invalid URL!',
	          text: "Different URL Reading.",
	          type: 'error',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
				}
			}
			else {
        Swal.fire({
        	alert(content)
          title: 'Invalid URL!',
          text: "Please Try Again.",
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Close'
        });
			}
			
		});
		Instascan.Camera.getCameras().then(function (cameras){
			if(cameras.length>0){
				scanner.start(cameras[1]);
				$('[name="options"]').on('change',function(){
					if($(this).val()==1){
						if(cameras[0]!=""){
							scanner.start(cameras[0]);
						}else{
							// alert('No Front camera found!');
	            Swal.fire({
	              title: 'No Front camera found!',
	              text: "",
	              type: 'info',
	              showCancelButton: false,
	              confirmButtonColor: '#3085d6',
	              cancelButtonColor: '#d33',
	              confirmButtonText: 'Close'
	            });
						}
					}else if($(this).val()==2){
						if(cameras[1]!=""){
							scanner.start(cameras[1]);
						}else{
							// alert('No Back camera found!');
	            Swal.fire({
	              title: 'No Back camera found!',
	              text: "",
	              type: 'info',
	              showCancelButton: false,
	              confirmButtonColor: '#3085d6',
	              cancelButtonColor: '#d33',
	              confirmButtonText: 'Close'
	            });
						}
					}
				});
			}else{
				console.error('No cameras found.');
        Swal.fire({
          title: 'No cameras found.',
          text: "",
          type: 'info',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Close'
        });
			}
		}).catch(function(e){
			console.error(e);
      Swal.fire({
        title: 'Error!',
        text: "Please try again.",
        type: 'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Close'
      });
		});

		$("#stopcamera").click(function() {
			scanner.stop();
		});
		$("#startcamera").click(function() {
			scanner.start();
		});

		function isUrl(s) {
		 var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		 return regexp.test(s);
		}
	</script>
@endsection