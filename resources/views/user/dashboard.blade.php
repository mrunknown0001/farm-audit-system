@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('style')
<style>
	.image-upload > input
	{
		display: none;
	}

	.image-upload i
	{
	  cursor: pointer;
	}
</style>
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
				<form action="{{ route('upload') }}" id="imageUploadForm" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="image-upload">
						<input type="file" id="upload" name="upload" accept="image/*" capture>
						<label for="upload">
							<span id="camera"><i class="fa fa-camera fa-3x"></i></span>
						</label>
						{{-- <button type="submit" disabled="" id="submit"><i class="fa fa-upload fa-3x"></i></button> --}}
					</div>
					
				</form>
			</div>		
		</div>
		<div class="row">
			<div class="col-md-6">
				@foreach($uploads as $key => $u)
					<p><a href="/uploads/test/{{ $u->filename }}">{{ $u->filename }}</a></p>
				@endforeach
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(function() {
     $("#upload").change(function (){
       $("#submit").attr('disabled', false);
       $("#camera").addClass('btn btn-success');
       $("#submit").addClass('btn btn-success');
     });
  });

$(document).ready(function (e) {
  $('#imageUploadForm').on('submit',(function(e) {
    e.preventDefault();
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
        // console.log(data);
        Swal.fire({
          title: 'Image Uploaded!',
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
        // console.log(data);
	      Swal.fire({
				  type: 'error',
				  title: 'Error Occured',
				  text: 'Please Try Again.',
				  // footer: '<a href="">Why do I have this issue?</a>'
				});
      }
    });
  }));

  $("#upload").on("change", function() {
    $("#imageUploadForm").submit();
  });
});
</script>
@endsection