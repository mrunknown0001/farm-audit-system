		@if(\App\Http\Controllers\AccessController::checkAccess(Auth::user()->id, 'audit_marshal'))
			<div class="row">
				<div class="col-md-12 text-center">
					<p><a href="{{ route('audit.qr') }}" id='auditbutton' class="btn btn-primary btn-lg"><i class="fa fa-search"></i> Start Audit</a></p>
				</div>
			</div>
		@endif
		@if(\App\Http\Controllers\AccessController::checkAccess(Auth::user()->id, 'reports'))
			<div class="row">
				<div class="col-md-4">
					<div class="small-box bg-red">
						<div class="inner">
							<h3>Auditables</h3>
							<p>Auditable Locations</p>
						</div>
						<div class="icon">
							<i class="fa fa-map-marker"></i>
						</div>
						<a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
		@endif