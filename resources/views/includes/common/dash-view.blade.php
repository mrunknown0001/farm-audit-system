		@inject('accesscontroller', '\App\Http\Controllers\AccessController')
		@inject('datacontroller', '\App\Http\Controllers\DataController')

		@if($accesscontroller->checkAccess(Auth::user()->id, 'audit_marshal'))
			<div class="row">
				<div class="col-md-12 text-center">
					<p><a href="{{ route('audit.qr') }}" id='auditbutton' class="btn btn-primary btn-lg"><i class="fa fa-search"></i> Start Audit</a></p>
				</div>
			</div>
		@endif
		<div class="row">
			@if($accesscontroller->checkAccess(Auth::user()->id, 'auditable_module'))
				<div class="col-md-4">
					<div class="small-box bg-primary">
						<div class="inner">
							<h3>Auditables</h3>
							<p>Auditable Locations</p>
						</div>
						<div class="icon">
							<i class="fa fa-map-marker"></i>
						</div>
						<a href="{{ route('auditables') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			@endif
			@if($accesscontroller->checkAccess(Auth::user()->id, 'audit_reviewer'))
				<div class="col-md-4">
					<div class="small-box bg-primary">
						<div class="inner">
							<h3>{{ $datacontroller->getToReview() }}</h3>
							<p>Review Audit</p>
						</div>
						<div class="icon">
							<i class="fa fa-list"></i>
						</div>
						<a href="{{ route('audit.review') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			@endif
		</div>
		@if($accesscontroller->checkAccess(Auth::user()->id, 'reports'))
			<div class="row">
				<div class="col-md-12">
          <!-- BAR CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Audit Data - Location: <strong><span id="report_location_name"></span></strong></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            	<div class="row form-group">
            		<div class="col-md-3">
            			<select name="report_farm" id="report_farm" class="form-control">
		            		<option value="">Select Farm</option>
		            	</select>
            		</div>
	            	<div class="col-md-3">
		            	<select name="report_location" id="report_location" class="form-control">
		            		<option value="">Select Location</option>
		            	</select>  		
	            	</div>
	            	<div class="col-md-3">
		            	<select name="report_sub_location" id="report_sub_location" class="form-control" style="display: none;">
		            		<option value="">Select Sub Location</option>
		            	</select> 
	            	</div>
	            </div>
              <div class="chart">
                {{-- <canvas id="barChart" style="height:230px"></canvas> --}}
                <div id="barChart" style="height: 500px; width: auto;"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
				</div>
			</div>
		@endif