@extends('layouts.app')

@inject('assignmentcontroller', '\App\Http\Controllers\AssignmentController')

@section('title')
	User Assignment
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
		<h1>User Assignment</a></h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('assignments') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Assignments</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form id="assignmentform" action="{{ route('post.assign.user') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					@if(isset($users))
						<div id="nameDiv" class="form-group {{ $errors->first('user') ? 'has-error' : ''  }}">
							<label for="user">User</label>
							<select id="user" name="user" class="form-control" required>
								<option value="">Select User</option>
								@foreach($users as $key => $u)
									<option value="{{ $u->id }}">{{ $u->last_name . ', ' . $u->first_name }}</option>
								@endforeach
							</select>
							@if($errors->first('user'))
	            	<span class="help-block"><strong>{{ $errors->first('user') }}</strong></span>
	            @endif
						</div>
					@else
						<div id="nameDiv" class="form-group {{ $errors->first('user') ? 'has-error' : ''  }}">
							<label for="name">User</label>
							<input type="text" name="name" id="user" readonly class="form-control" value="{{ $user->first_name . ' ' . $user->last_name }}">
							<input type="hidden" name="user" value="{{ $user->id }}">
						</div>
					@endif

					<div class="form-group">
						<h4>Auditable Locations</h4>
						@foreach($locations as $key => $l)
							<div>
								<input type="checkbox" name="location[]" id="loc-{{ $l->id }}" value="{{ $l->id }}" {{ isset($user) ? $assignmentcontroller->checkAssignment($user->id, 'loc', $l->id) ? 'checked' : '' : '' }}>
								<label for="loc-{{ $l->id }}">{{ $l->farm->code . '-' . $l->location_name }}</label>
								@if($l->has_sublocation == 1)
									<div class="row">
										<div class="col-md-10 col-md-offset-1"  id="divloc-{{ $l->id }}">
											@foreach($l->sub_locations as $key => $s)
												<input type="checkbox" name="sub_location[]" id="sub-{{ $s->id }}" value="{{ $s->id }}" {{ isset($user) ? $assignmentcontroller->checkAssignment($user->id, 'sub', $s->id) ? 'checked' : '' : '' }}>
												<label for="sub-{{ $s->id }}">{{ $s->sub_location_name }}</label>
											@endforeach
										</div>
									</div>
								@endif
							</div>
						@endforeach
					</div>
					<div class="form-group">
						<button type="submit" id="assignmentsubmi" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	{{-- <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> --}}
	{{-- <script type="text/javascript" src="{{ asset('js/bootstrap-select.min.js') }}"></script> --}}
	<script>
		$(document).ready(function() {
		  $('#assignmentform').on('submit',(function(e) {
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
		        console.log(data);
		        // Close Upload Animation here
		        $("body").removeClass("loading");
		        Swal.fire({
		          title: 'User Assgined!',
		          text: "",
		          type: 'success',
		          showCancelButton: false,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Close'
		        });
		      },
		      error: function(data){
		        console.log("error");
		        console.log(data.responseJSON);
		        var msg = data.responseJSON.errors['location'][0];
		        $("body").removeClass("loading");
			      Swal.fire({
						  type: 'error',
						  title: 'Error Occured',
						  text: msg	,
						});
		      }
		    });
		  }));

		  
		});

	</script>
@endsection