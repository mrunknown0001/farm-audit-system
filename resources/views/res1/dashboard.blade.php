@extends('layouts.app')

@section('title')
	Employee Dashboard
@endsection

@section('style')
	<style>
		.round-btn {
			height: 100px;
			width: 100px;
			border-radius: 50%;
		}

    .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("/gif/loading-buffering.gif") center no-repeat;
    }
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;   
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
	</style>
@endsection

@section('header')
	@include('employee.includes.header')
@endsection

@section('sidebar')
	@include('employee.includes.sidebar')
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
			<div class="col-sm-offset-5 col-sm-2 text-center">
				@if(empty($in))
					<p id="changepunchin">
						<button id='punchin' data-text='Are you sure you want to time in?' class="round-btn btn btn-primary"><i class="fa fa-map-marker"></i> Punch In</button>
					</p>
				@else
					<button id='punchout' @if(!empty($out)) disabled @endif data-text='Are you sure you want to time out?' class="round-btn btn btn-primary"><i class="fa fa-map-marker"></i> Punch Out</button>
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-4 col-md-4 text-center">
				<hr>
				<p>Time In Today:  <b><span id="in">@if(!empty($in))  {{ date('H:i:s A', strtotime($in->created_at)) }} @else No Log @endif</span></b></p>
				<p>Time Out Today: <b><span id="out">@if(!empty($out))  {{ date('H:i:s A', strtotime($out->created_at)) }} @else No Log @endif</span></b></p>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script src="{{ asset('js/jquery.js') }}"></script>
	<script>
		var options = {
		  enableHighAccuracy: true,
		  timeout: 10000,
		  maximumAge: 10000
		};
		function getLocation() {
		  if (navigator.geolocation) {
		  	$("body").addClass("loading"); 
		    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
		  } else { 
		  	$("body").removeClass("loading"); 
	      Swal.fire({
				  type: 'error',
				  title: 'Geolocation Error',
				  text: 'Geolocation is not supported by this browser.',
				  // footer: '<a href="">Why do I have this issue?</a>'
				})
		  }
		}

		function showPosition(position) {
		  // x.innerHTML = "Latitude: " + position.coords.latitude + 
		  // "<br>Longitude: " + position.coords.longitude;
		  // console.log('Latitude:' + position.coords.latitude);
		  // console.log('Longitude:' + position.coords.longitude);
		  var uuid = new DeviceUUID().get();
		  var du = new DeviceUUID().parse();
	    var dua = [
	        du.language,
	        du.platform,
	        du.os,
	        du.cpuCores,
	        du.isAuthoritative,
	        du.silkAccelerated,
	        du.isKindleFire,
	        du.isDesktop,
	        du.isMobile,
	        du.isTablet,
	        du.isWindows,
	        du.isLinux,
	        du.isLinux64,
	        du.isMac,
	        du.isiPad,
	        du.isiPhone,
	        du.isiPod,
	        du.isSmartTV,
	        du.pixelDepth,
	        du.isTouchScreen
	    ];
		  if(position.coords.latitude == NaN || position.coords.longitude == NaN) {
		  	$("body").removeClass("loading"); 
	      Swal.fire({
				  type: 'error',
				  title: 'Unknown Error',
				  text: 'An unknown error occurred.',
				  // footer: '<a href="">Why do I have this issue?</a>'
				});
		  }
		  else {
			  $.ajax({
			  	url: "/e/geoloc/punch/" + position.coords.latitude + "/" + position.coords.longitude + "/" + uuid + "/" + dua,
			  	type: "GET",
          success: function(data) {
          	console.log(data);
          	$("body").removeClass("loading"); 
            Swal.fire({
              title: 'Alright!',
              text: "",
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Close'
            });

            // Show Time in or time out
            // if time in and timeout on day disable button
            if(data == 'in') {
						  $.ajax({
						  	url: "/e/in-today",
						  	type: "GET",
			          success: function(data) {
			          	$('#in').html(data);
			          	$('#changepunchin').html("<button id='punchout' data-text='Are you sure you want to time out?' class='round-btn btn btn-primary'><i class='fa fa-map-marker'></i> Punch Out</button>");
			          }
			        });
            }
            if(data == 'out') {
						  $.ajax({
						  	url: "/e/out-today",
						  	type: "GET",
			          success: function(data) {
			          	$('#out').html(data);
			          }
			        });
            	$("#punchout").attr("disabled", true);
            }
          },
          error: function(error) {
          	console.log(error);
          	$("body").removeClass("loading"); 
            Swal.fire({
              title: 'Error Occured! Tray Again.',
              text: "",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Close'
            });
          }
			  });
			}
		}

		function showError(error) {
			// Error Show on Sweet Alert
		  switch(error.code) {
		    case error.PERMISSION_DENIED:
		      // x.innerHTML = "User denied the request for Geolocation."
		      console.log("User denied the request for Geolocation.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Permission Denied',
					  text: 'User denied the request for Geolocation.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					})
		      break;
		    case error.POSITION_UNAVAILABLE:
		      // x.innerHTML = "Location information is unavailable."
		      console.log("Location information is unavailable.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Position Unavailable',
					  text: 'Location information is unavailable.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					});
		      break;
		    case error.TIMEOUT:
		      // x.innerHTML = "The request to get user location timed out."
		      console.log("The request to get user location timed out.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Timeout Error',
					  text: 'The request to get user location timed out.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					})
		      break;
		    case error.UNKNOWN_ERROR:
		      // x.innerHTML = "An unknown error occurred."
		      console.log("An unknown error occurred.");
		      $("body").removeClass("loading"); 
		      Swal.fire({
					  type: 'error',
					  title: 'Unknown Error',
					  text: 'An unknown error occurred.',
					  // footer: '<a href="">Why do I have this issue?</a>'
					});
		      break;
		  }
		}


    $(document).on('click', '#punchin', function (e) {
        e.preventDefault();
        var text = $(this).data('text');
        Swal.fire({
          title: 'Confirm Time In?',
          text: text,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm'
        }).then((result) => {
          if (result.value) {
          	getLocation();

          }
          else {
            Swal.fire({
              title: 'Action Cancelled',
              text: "",
              type: 'info',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Close'
            });
          }
        });
    });
    $(document).on('click', '#punchout', function (e) {
        e.preventDefault();
        var text = $(this).data('text');
        Swal.fire({
          title: 'Confirm Time Out?',
          text: text,
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm'
        }).then((result) => {
          if (result.value) {
          	getLocation();

          }
          else {
            Swal.fire({
              title: 'Action Cancelled',
              text: "",
              type: 'info',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Close'
            });
          }
        });
    });
	</script>

@endsection