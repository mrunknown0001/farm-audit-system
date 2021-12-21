@extends('layouts.app')

@section('title')
	Review Audit
@endsection

@section('style')
	<link href="https://cdn.bootcss.com/balloon-css/0.5.0/balloon.min.css" rel="stylesheet">
  <link href="{{ asset('magnify/css/jquery.magnify.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('summernote/summernote.min.css') }}">
  <style>
	  .overlay{
      display: none;
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 999;
      background: rgba(255,255,255,0.8) url("/gif/apple.gif") center no-repeat;
	  }
	  body.loading{
	      overflow: hidden;   
	  }
	  body.loading .overlay{
	      display: block;
	  }
  </style>
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
			@if(isset($audit->audit_item))
				<div class="col-md-12">
					<h2>Location: <strong>{{ $audit->field1 == 'loc' ? $audit->location->farm->code . ' - ' . $audit->location->location_name : $audit->sub_location->location->farm->code . ' - ' . $audit->sub_location->location->location_name . ' - ' . $audit->sub_location->sub_location_name }}</strong></h2>
					@if($audit->compliance == 1) 
						<p><span class="label label-success">COMPLIANT <i class="fa fa-check"></i></span></p>
					@else
						<p><span class="label label-danger">NON-COMPLIANT <i class="fa fa-times"></i></span></p>
					@endif
					<p>Marshal: <strong>{{ $audit->auditor->first_name . ' ' . $audit->auditor->last_name }}</strong></p>
					<p>Timestamp: <strong>{{ $audit->created_at }}</strong></p>
					<p><button class="btn btn-primary btn-xs" id="showmap"><i class="fa fa-map-marked-alt"></i> View Location</button></p>
					<div id="mapholder" style="display: none;"></div>
					<hr>
					<p>Audit Item: <strong>{{ $audit->audit_item->item_name . ' (' . $audit->audit_item->time_range . ')' }}</strong></p>
					@if($audit->compliance == 0)
						<p>Bakit hindi Compliant?</p>
						<p><i>{{ $audit->non_compliance_remarks }}</i></p>
						@if($audit->field2 != null) {{-- Remarks Field in Audit Table --}}
							<p>Additional Remarks</p>
							<p><i>{{ $audit->field2 }}</i></p>
						@endif
						@if(count($audit->images) > 0)
							<h4>Images Uploaded</h4>
							<div class="image-set m-t-20">
								@foreach($audit->images as $i)
									<a data-magnify="gallery" data-src="" data-caption="{{ $i->filename }}" data-group="a" href="{{ asset('/uploads/images/' . $i->filename) }}">
					          <img src="{{ asset('/uploads/images/' . $i->filename) }}" alt="" height="50px">
					        </a>
								@endforeach
							</div>
						@endif
					@endif
					<hr>
					<form id="reviewform" accept="{{ route('audit.post.review', ['id' => $audit->id]) }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<input type="checkbox" name="verified" id="verified" value="1" {{ $audit->verified == 1 ? 'checked' : '' }}> <label for="verified">Verify Correct</label>
						</div>
						<h4>Reviewer Remarks</h4>
						<textarea id="summernote" name="editordata">{{ $audit->reviewed == 1 ? $audit->review->review : '' }}</textarea>
						@if($audit->reviewed == 0)
							<button id="reviewsubmitbutton" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
						@endif
					</form>
					<div id="reviewedby"> 
						@if($audit->reviewed == 1)
							<p>Reviewed by: <strong>{{ $audit->reviewer->first_name . ' ' . $audit->reviewer->last_name }}</strong></p>
							<p>Review Timestamp: <strong>{{ $audit->review->created_at }}</strong></p>
						@endif
					</div>
				</div>
			@else
				<div class="colmd">
					<p class="text-center">No Data/Sample Data</p>
				</div>
			@endif
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script src="https://cdn.bootcss.com/prettify/r298/prettify.min.js"></script>
	<script src="{{ asset('magnify/js/jquery.magnify.js') }}"></script>
	<script src="{{ asset('summernote/summernote.min.js') }}"></script>
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw"></script>
  <script>
		$(document).ready(function() {
			@if($audit->reviewed == 1)
				$('#summernote').summernote('disable');
			@endif

		 $('#summernote').summernote({
        placeholder: 'Reviewer Remarks...',
        tabsize: 2,
        height: 150,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', []],
          // ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'help']]
        ]
		 });

			var lat = {{ $audit->latitude }};
			var lon = {{ $audit->longitude }};
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

			$("#showmap").click(function () {
				$("#mapholder").show();
			});


	  $('#reviewform').on('submit',(function(e) {
	    e.preventDefault();
			// Add Loading Animation here
	  	$("body").addClass("loading"); 
	    var formData = new FormData(this);
	    $.ajax({
	      type:'POST',
	      url: $(this).attr('action'),
	      data:formData,
	      cache:false,
	      contentType: false,
	      processData: false,
	      success:function(data){
	        console.log("success");
	        // Close Upload Animation here
	        $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Review Submitted!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	        // remove submit button
	        $('#reviewsubmitbutton').remove();
	        // readonly summernote
	        $('#summernote').summernote('disable');
	        // load the reviewedby content
	        $('#reviewedby').load('{{ route('auditor.review', ['id' => $audit->id]) }}');
	      },
	      error: function(data){
	        console.log("error");
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Try Again.',
					});

					var errors = data.responseJSON;
					console.log(errors);
	      }
	    });
	  }));



		});
    window.prettyPrint && prettyPrint();

    var defaultOpts = {
      draggable: true,
      resizable: true,
      movable: true,
      keyboard: true,
      title: true,
      modalWidth: 320,
      modalHeight: 320,
      fixedContent: true,
      fixedModalSize: false,
      initMaximized: false,
      gapThreshold: 0.02,
      ratioThreshold: 0.1,
      minRatio: 0.05,
      maxRatio: 16,
      headToolbar: ['maximize', 'close'],
      footToolbar: ['zoomIn', 'zoomOut', 'prev', 'fullscreen', 'next', 'actualSize', 'rotateRight'],
      multiInstances: true,
      initEvent: 'click',
      initAnimation: true,
      fixedModalPos: false,
      zIndex: 1090,
      dragHandle: '.magnify-modal',
      progressiveLoading: true
    };
  </script>
@endsection