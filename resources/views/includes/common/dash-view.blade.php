		@if(\App\Http\Controllers\AccessController::checkAccess(Auth::user()->id, 'audit_marshal'))
			<div class="row">
				<div class="col-md-12 text-center">
					<a href="{{ route('audit.qr') }}" id='auditbutton' class="btn btn-primary btn-lg"><i class="fa fa-search"></i> Start Audit</a>
				</div>
			</div>
		@endif
