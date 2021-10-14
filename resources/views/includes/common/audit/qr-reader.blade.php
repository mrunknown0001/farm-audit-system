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
				<video id="preview" class="p-1 border" style="width:100%;"></video>
				<div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
				  <label class="btn btn-primary active">
					<input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
				  </label>
				  <label class="btn btn-warning">
					<input type="radio" name="options" value="2" autocomplete="off"> Back Camera
				  </label>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
	<script type="text/javascript">
		var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
		scanner.addListener('scan',function(content){
			alert(content);
			window.location.href=content;
		});
		Instascan.Camera.getCameras().then(function (cameras){
			if(cameras.length>0){
				scanner.start(cameras[1]);
				$('[name="options"]').on('change',function(){
					if($(this).val()==1){
						if(cameras[0]!=""){
							scanner.start(cameras[0]);
						}else{
							alert('No Front camera found!');
						}
					}else if($(this).val()==2){
						if(cameras[1]!=""){
							scanner.start(cameras[1]);
						}else{
							alert('No Back camera found!');
						}
					}
				});
			}else{
				console.error('No cameras found.');
				alert('No cameras found.');
			}
		}).catch(function(e){
			console.error(e);
			alert(e);
		});
	</script>
@endsection