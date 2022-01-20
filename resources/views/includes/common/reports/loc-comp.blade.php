@extends('layouts.app')

@section('title')
	Location Compliance Reports
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
		<h1>Location Compliance Reports</h1>
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
				<form action="{{ route('report.post.location.compliance') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
					@csrf
					<div class="form-group {{ $errors->first('farm') ? 'has-error' : ''  }}">
						<label for="farm">Select Farm</label>
						<select name="farm" id="farm" class="form-control" required>
							<option value="">Select Farm</option>
							@foreach($farms as $key => $f)
								<option value="{{ $f->farm->id }}">{{ $f->farm->code }}</option>
							@endforeach
						</select>
						@if($errors->first('farm'))
	            	<span class="help-block"><strong>{{ $errors->first('farm') }}</strong></span>
	            @endif
					</div>
        	<div class="form-group">
        		<label for="location">Select Location</label>
          	<select name="location" id="location" class="form-control">
              <option value="">Select Location</option>
          	</select>  		
        	</div>
        	<div class="form-group">
        		{{-- <label for="sub_location">Select Sub Location</label> --}}
          	<select name="sub_location" id="sub_location" class="form-control" style="display: none;">
          		<option value="">Select Sub Location</option>
          	</select>  		
        	</div>
					<div class="row">
						<div class="col-md-6 form-group {{ $errors->first('from') ? 'has-error' : ''  }}">
							<label for="from">From Date</label>
							<input type="date" name="from" id="from" class="form-control" required>
							@if($errors->first('from'))
	            	<span class="help-block"><strong>{{ $errors->first('from') }}</strong></span>
	            @endif
						</div>
						<div class="col-md-6 form-group {{ $errors->first('to') ? 'has-error' : ''  }}">
							<label for="to">To Date</label>
							<input type="date" name="to" id="to" class="form-control" required>
							@if($errors->first('to'))
	            	<span class="help-block"><strong>{{ $errors->first('to') }}</strong></span>
	            @endif
						</div>
					</div>
					<div class="form-group">
						<button class="btn btn-danger"><i class="fa fa-file-export"></i> Export</button>
					</div>
				</form>
			</div>
		</div>
		<div class="overlay"></div>
	</section>
</div>
@endsection

@section('script')
	<script>
  $(document).ready(function () {

    $('#farm').change(function () {
      $('#sub_location').hide();
      $('#sub_location').removeAttr('required');
      
      var id = $(this).val();
      $.ajax({
        url: "/farm/location/get/" + id,
        dataType: "json",
        async: false,
        success: function(data) {
          // console.log(data);
          $('#location option').remove();
          $('#location').append('<option value="">Select Location</option>');
          $('#location').append('<option value="all">All Locations</option>');
          $.each(data, function(k, v) {
            $('#location').append('<option value="'+ data[k]['id'] +'" data-id="'+ data[k]['has_sublocation'] +'">'+ data[k]['location_name'] +'</option>');
          });
        }
      });      
    });

    $('#location').change(function() {
      var has_sublocation = $(this).find(':selected').data('id');
      var id = $(this).val();
      if(id == '') {

        return ;
      }
      else if (id == 'all') {
        $('#sub_location').hide();
        $('#sub_location').removeAttr('required');
      }
      else if (id != '') {
        if(has_sublocation == 1) {
          $('#sub_location').show();
          $('#sub_location').attr('required', 'required');
        
          // load sublocation
          // /farm/sublocation/get/{id}
          $.ajax({
            url: "/farm/sublocation/get/" + id,
            dataType: "json",
            async: false,
            success: function(data) {
              // console.log(data);
              $('#sub_location option').remove();
              $('#sub_location').append('<option value="">Select Sub Location</option>');
              $.each(data, function(k, v) {
                $('#sub_location').append('<option value="'+ data[k]['id'] +'">'+ data[k]['sub_location_name'] +'</option>');
              });
            }
          }); 
          return false;
        }
        else {
          $('#sub_location').hide();
          $('#sub_location').removeAttr('required');
          // load data for location with id
          // $("body").addClass("loading"); 
          // $.ajax({
          //   url: "/daily/loc/compliance/" + id,
          //   dataType: "json",
          //   async: false,
          //   success: function(data) {
          //     // console.log(data);
          //   }
          // }); 
          
          // $("body").removeClass("loading");
          // return ;

        }

      }

    });

    $('#report_sub_location').change(function () {
      var id = $(this).val();
      
      
      // if(id == '') {
      //   return ;
      // }
      // else if(id != '') {
      //   $("body").addClass("loading"); 
      //   // load data
      //   $.ajax({
      //     url: "/daily/sub/compliance/" + id,
      //     dataType: "json",
      //     async: false,
      //     success: function(data) {
      //       // console.log(data);

      //     }
      //   }); 
      //   $("body").removeClass("loading");
      //   return false;
      // }
      
    });
  });
	</script>
@endsection