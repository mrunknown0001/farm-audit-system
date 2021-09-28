@extends('layouts.app')

@section('title')
	Update User
@endsection

@section('style')

@endsection

@section('header')
	@include('admin.includes.header')
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Update User</h1>
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
			<div class="col-md-6 col-md-offset-3">
				<h3>User Detail</h3>
				<form action="{{ route('admin.post.update.user', ['id' => $user->id]) }}" method="POST">
					@csrf
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" placeholder="First Name" value="{{ $user->first_name }}" class="form-control" name="first_name" id="first_name" required>
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" placeholder="Last Name" value="{{ $user->last_name }}" class="form-control" name="last_name" id="last_name" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" placeholder="Email" value="{{ $user->email }}" class="form-control" name="email" id="email" required>
					</div>
					<div class="form-group">
						<label for="role">Role</label>
						<select class="form-control" id="role" name="role" required>
							<option value="">Select Role</option>
							<option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Administrator</option>
							<option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Manager</option>
							<option value="4" {{ $user->role_id == 4 ? 'selected' : '' }}>Employee</option>
						</select>
					</div>
					<div class="form-group">
						<label for="manager">Manager</label>
						<select class="form-control" id="manager" name="manager" disabled="true" required="false">
							<option value="" selected>Select Manager</option>
							@foreach($managers as $key => $m)
							<option value="{{ $m->id }}"  {{ $user->manager_id == $m->id ? 'selected' : '' }}>{{ $m->first_name . ' ' . $m->last_name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="text" placeholder="Password" class="form-control" name="password" id="password">
					</div>
					
					<div class="form-group">
						<label for="active">Active?</label>
						<input type="checkbox" name="active" id="active" {{ $user->active == 1 ? 'checked' : '' }}>
					</div>

					<div class="form-group">
						<button class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

	<script>
		$('#role').change(function () {
			if($('#role').val() == 4) {
				$("#manager").attr("disabled", false);
				$("#manager").attr("required", true);
			}
			else {
				$("#manager").attr("disabled", true);
				$("#manager").attr("required", false);
				$('#manager').val('')
			}
		});

	</script>

@endsection