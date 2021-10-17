@extends('layouts.app')

@section('title')
	Set User Access
@endsection

@section('style')
	<style>
		ul.list-inline li {
			padding-right:2rem;
		}
	</style>
@endsection

@section('sidebar')
	@include('admin.includes.sidebar')
@endsection

@section('content')
	<div class="content-wrapper">
	<section class="content-header">
		<h1>Set User Access</h1>
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
			<div class="col-md-10 col-md-offset-1">
				<h4>User: {{ $user->first_name . ' ' . $user->last_name }}</h4>
				<form action="{{ route('post.set.access', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" value="{{ $user->id }}" name="user_id">
					<div class="form-group">
						<h4>Location:</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'location_module') ? 'checked' : '' }} value="location_module" name="access[]" id="location_module"> <label for="location_module">Module</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'location_add') ? 'checked' : '' }} value="location_add" name="access[]" id="location_add"> <label for="location_add">Add</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'location_edit') ? 'checked' : '' }} value="location_edit" name="access[]" id="location_edit"> <label for="location_edit">Edit</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'location_delete') ? 'checked' : '' }} value="location_delete" name="access[]" id="location_delete"> <label for="location_delete">Delete</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Sub Location:</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'sub_location_module') ? 'checked' : '' }} value="sub_location_module" name="access[]" id="sub_location_module"> <label for="sub_location_module">Module</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'sub_location_add') ? 'checked' : '' }} value="sub_location_add" name="access[]" id="sub_location_add"> <label for="sub_location_add">Add</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'sub_location_edit') ? 'checked' : '' }} value="sub_location_edit" name="access[]" id="sub_location_edit"> <label for="sub_location_edit"> Edit</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'sub_location_delete') ? 'checked' : '' }} value="sub_location_delete" name="access[]" id="sub_location_delete"> <label for="sub_location_delete">Delete</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Audit Item:</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_item_module') ? 'checked' : '' }} value="audit_item_module" name="access[]" id="audit_item_module"> <label for="audit_item_module">Module</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_item_add') ? 'checked' : '' }} value="audit_item_add" name="access[]" id="audit_item_add"> <label for="audit_item_add">Add</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_item_edit') ? 'checked' : '' }} value="audit_item_edit" name="access[]" id="audit_item_edit"> <label for="audit_item_edit"> Edit</label></li>
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_item_delete') ? 'checked' : '' }} value="audit_item_delete" name="access[]" id="audit_item_delete"> <label for="audit_item_delete">Delete</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Assignment:</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'assignment_module') ? 'checked' : '' }} value="assignment_module" name="access[]" id="assignment_module"> <label for="assignment_module">Module</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Auditables</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'auditable_module') ? 'checked' : '' }} value="auditable_module" name="access[]" id="auditable_module"> <label for="auditable_module">Module</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Audit Reviewer</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_reviewer') ? 'checked' : '' }} value="audit_reviewer" name="access[]" id="audit_reviewer"> <label for="audit_reviewer">Module</label></li>
						</ul>
					</div>
					<div class="form-group">
						<h4>Audit Marshal</h4>
						<ul class="list-inline">
							<li><input type="checkbox" {{ \App\Http\Controllers\AccessController::checkAccess($user->id, 'audit_marshal') ? 'checked' : '' }} value="audit_marshal" name="access[]" id="audit_marshal"> <label for="audit_marshal">Module</label></li>
						</ul>
					</div>
					<div class="form-group">
						<button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection

@section('script')

@endsection