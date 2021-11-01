@extends('layouts.app')

@section('title')
	Review Audit
@endsection

@section('style')
	<link href="https://cdn.bootcss.com/balloon-css/0.5.0/balloon.min.css" rel="stylesheet">
  <link href="{{ asset('magnify/css/jquery.magnify.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('summernote/summernote.min.css') }}">
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
					<p><span class="label label-danger">NON-COMPLIANT <i class="fa fa-times"></i></span></p>
				@endif
				<p><button class="btn btn-primary btn-xs" id="showmap"><i class="fa fa-map-marked-alt"></i> View Location</button></p>
				<div id="mapholder" style="display: none;"></div>
				<p>Timestamp: <strong>{{ $audit->created_at }}</strong></p>
				<hr>
				<p>Audit Item: <strong>{{ $audit->audit_item->item_name . ' (' . $audit->audit_item->time_range . ')' }}</strong></p>
				@if($audit->compliance == 0)
					<p>Bakit hindi Compliant?</p>
					<p><i>{{ $audit->non_compliance_remarks }}</i></p>
					@if($audit->field2 != null)
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
				<form accept="{{ route('audit.post.review', ['id' => $audit->id]) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<input type="checkbox" name="verified" id="verified" value="1"> <label for="verified">Verify Correct</label>
					</div>
					<h4>Reviewer Remarks</h4>
					<textarea id="summernote" name="editordata"></textarea>
					<button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script src="https://cdn.bootcss.com/prettify/r298/prettify.min.js"></script>
	<script src="{{ asset('magnify/js/jquery.magnify.js') }}"></script>
	<script src="{{ asset('summernote/summernote.min.js') }}"></script>
  <script>
		$(document).ready(function() {
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
          ['insert', []]
          // ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'help']]
        ]
		 });

			var latlon = {{ $audit->latitude }} + "," + {{ $audit->longitude }};
			var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=14&size=400x300&sensor=false&key=AIzaSyAQvHBXoM12klgegEIh1rTfklVQR3XkAXw";
			document.getElementById("mapholder").innerHTML = "<img class='img img-responsive' src='"+img_url+"'>";

			$("#showmap").click(function () {
				$("#mapholder").show();
			});
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