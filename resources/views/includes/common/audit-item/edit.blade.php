@extends('layouts.app')

@inject('audititemcontroller', '\App\Http\Controllers\AuditItemController')

@section('title')
	Update Audit Item
@endsection

@section('style')
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
		<h1>Update Audit Item</h1>
		<ol class="breadcrumb">
			<li><a href="javascript:void(0)"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">@yield('title')</li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<p><a href="{{ route('audit.item') }}" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back to Audit Items</a></p>
				@include('includes.all')
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<form id="audititemform" action="{{ route('audit.item.update', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" name="id" value="{{ $item->id }}">
					<div class="form-group {{ $errors->first('farm') ? 'has-error' : ''  }}">
						<label for="farm">Farm</label>
						<select name="farm" id="farm" class="form-control" required readonly>
							<option value="">Select Farm</option>
							@foreach($farms as $key => $n)
								<option value="{{ $n->id }}" {{ $item->farm_id == $n->id ? 'selected' : '' }}>{{ $n->name }}</option>
							@endforeach
						</select>
						@if($errors->first('farm'))
            	<span class="help-block"><strong>{{ $errors->first('farm') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('audit_name') ? 'has-error' : ''  }}">
						<label for="audit_name">Audit Name</label>
						<select name="audit_name" id="audit_name" class="form-control" required>
							<option value="">Select Audit Name</option>
							@foreach($names as $key => $n)
								<option value="{{ $n->id }}" {{ $item->audit_item_category_id == $n->id ? 'selected' : '' }}>{{ $n->category_name }}</option>
							@endforeach
						</select>
						@if($errors->first('audit_name'))
            	<span class="help-block"><strong>{{ $errors->first('audit_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('audit_item_name') ? 'has-error' : ''  }}">
						<label for="audit_item_name">Audit Item Name</label>
						<input type="text" name="audit_item_name" id="audit_item_name" value="{{ $item->item_name }}" placeholder="Audit Item Name" class="form-control" required>
						@if($errors->first('audit_item_name'))
            	<span class="help-block"><strong>{{ $errors->first('audit_item_name') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('description') ? 'has-error' : ''  }}">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
						@if($errors->first('description'))
            	<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
            @endif
					</div>
					<div class="form-group {{ $errors->first('time_range') ? 'has-error' : ''  }}">
						<label for="time_range">Time Range</label>
						<input type="text" name="time_range" id="time_range" value="{{ $item->time_range }}" placeholder="Example: 8am-9am, 5pm-6pm" class="form-control" required>
						@if($errors->first('time_range'))
            	<span class="help-block"><strong>{{ $errors->first('time_range') }}</strong></span>
            @endif
					</div>
					{{-- <div class="form-group" id="items">
						<p><label>Checklist</label> <button id="addChecklist" type="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i></button></p>
						@if(count($item->checklists) > 0)
							@foreach($item->checklists as $key => $c)
								<div id="itemrow{{ $c->id }}" class="itemrowclass row form-group"><div class="col-md-11"><input class="form-control" value="{{ $c->checklist }}" name="checklist[]" placeholder="Audit Item Checklist" required/></div><div class="col-md-1"><button type="button" class="btn btn-danger" onclick="remove('{{ $c->id }}')"><i class="fa fa-times-circle"></i></button></div></div>
							@endforeach
						@endif
					</div> --}}
					<div class="form-group">
						<h3>Locations Applied</h3>
						@if(count($locations) > 0)
							<div class="row"> 
								@foreach($locations as $key => $l)
									<div class="col-md-3"><input type="checkbox" name="locations[]" {{ $audititemcontroller->checkifset($item->id, $l->id) ? 'checked' : '' }} id="location{{ $l->id }}" value="{{ $l->id }}"> <label for="location{{ $l->id }}">{{ $l->location_name }}</label></div>
								@endforeach
							</div>
						@else
							<p>No Location Found!</p>
						@endif
					</div>
					<div class="form-group">
						<button class="btn btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function() {
			var id= {{ count($item->checklists) }};
			$("#addChecklist").click(function (e) {
				id += 1;
			  $("#items").append('<div id="itemrow' + id + '" class="itemrowclass row form-group"><div class="col-md-11"><input class="form-control" name="checklist[]" placeholder="Audit Item Checklist" required/></div><div class="col-md-1"><button type="button" class="btn btn-danger" onclick="remove(' + id + ')"><i class="fa fa-times-circle"></i></button></div></div>');
			});


	  $('#audititemform').on('submit',(function(e) {
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
	        // console.log("success");
	        // console.log(data);
	        // Close Upload Animation here
	        $("body").removeClass("loading");
	        Swal.fire({
	          title: 'Audit Item Updated!',
	          text: "",
	          type: 'success',
	          showCancelButton: false,
	          confirmButtonColor: '#3085d6',
	          cancelButtonColor: '#d33',
	          confirmButtonText: 'Close'
	        });
	      },
	      error: function(data){
	        console.log(data.responseJSON);
	        $("body").removeClass("loading");
		      Swal.fire({
					  type: 'error',
					  title: 'Error Occured',
					  text: 'Please Try Again.',
					});
	      }
	    });
	  }));



		});

		function remove(id){
			did = '#itemrow' + id
			// console.log(did)
			$(did).remove();
		}
	</script>
@endsection