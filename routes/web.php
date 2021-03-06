<?php
use Illuminate\Support\Facades\Route;

// Route::get('/ts', 'TestController@timestamp');
// Route::get('/qr1', 'TestController@qr1');

// Route::post('upload', 'TestController@upload')->name('upload');

// Route::get('/qr', function () {
// 	return view('qr');
// });
// 
// Route::get('timecheck/{time}', 'AuditItemController@timecheck');

// Route::get('/days', 'TestController@days');

Route::get('/range/{id}', 'TestController@range');

Route::get('/', function () {
    return redirect()->route('login');
});

# Login for User
Route::get('/login', 'LoginController@login')->name('login');
# Post Login for User
Route::post('/login', 'LoginController@postLogin')->name('post.login');
# Login for Admin
Route::get('/admin/login', 'LoginController@adminLogin')->name('admin.login');
#post Login for Admin
Route::post('/admin/login', 'LoginController@postAdminLogin')->name('post.admin.login');

# Login for Super Admin

Route::get('/logout', 'LoginController@logout')->name('logout');

# Common Auth
Route::group(['middleware' => 'auth'], function () {
	# Profile
	Route::get('/profile', 'UserController@profile')->name('profile');
	# Change Password
	Route::get('/change-password', 'UserController@changePassword')->name('change.password');
	Route::post('/change-password', 'UserController@postChangePassword')->name('post.change.password');

	# Access Driven
	# Location and Sublocation Management
	Route::get('/locations', 'LocationController@index')->name('locations');
	Route::get('/location/add', 'LocationController@create')->name('location.add');
	Route::post('/location/add', 'LocationController@store')->name('location.post.add');
	Route::get('/location/edit/{id}', 'LocationController@edit')->name('location.edit');
	Route::post('/location/edit/{id}', 'LocationController@update')->name('location.update');
	Route::get('/location/remove/{id}', 'LocationController@remove')->name('location.remove');

	Route::get('/sub-locations', 'SubLocationController@index')->name('sub.locations');
	Route::get('/sub-location/add', 'SubLocationController@create')->name('sub.location.add');
	Route::post('/sub-location/add', 'SubLocationController@store')->name('sub.location.post.add');
	Route::get('/sub-location/edit/{id}', 'SubLocationController@edit')->name('sub.location.edit');
	Route::post('/sub-location/edit/{id}', 'SubLocationController@update')->name('sub.location.update');
	Route::get('/sub-location/remove/{id}', 'SubLocationController@remove')->name('sub.location.remove');

	# Supervisor and Caretaker/User Assignment to Locations
	Route::get('/assignments', 'AssignmentController@index')->name('assignments');
	Route::get('/assign-user', 'AssignmentController@create')->name('assign.user');
	Route::post('/assign-user', 'AssignmentController@store')->name('post.assign.user');
	Route::get('/assign-user/update/{id}', 'AssignmentController@update')->name('update.user.assignment');
	Route::get('/assign-user/remove/{id}', 'AssignmentController@remove')->name('remove.user.assignment');

	# Audit Item Management
	Route::get('/audit-items', 'AuditItemController@index')->name('audit.item');	
	Route::get('/audit-item/add', 'AuditItemController@create')->name('audit.item.add');
	Route::post('/audit-item/add', 'AuditItemController@store')->name('audit.item.post.add');
	Route::get('/audit-item/edit/{id}', 'AuditItemController@edit')->name('audit.item.edit');
	Route::post('/audit-item/edit/{id}', 'AuditItemController@update')->name('audit.item.update');
	Route::get('/audit-item/remove/{id}', 'AuditItemController@remove')->name('audit.item.remove');
	# Get Locations on Audit Item Based on Farm ID
	Route::get('/location/farm/{id}', 'LocationController@getLoationFarm')->name('farm.get.locations');

	# Audit Name Management || audit_item_category
	Route::get('/audit-names', 'AuditItemCategoryController@index')->name('audit.name');	
	Route::get('/audit-name/add', 'AuditItemCategoryController@create')->name('audit.name.add');
	Route::post('/audit-name/add', 'AuditItemCategoryController@store')->name('audit.name.post.add');
	Route::get('/audit-name/edit/{id}', 'AuditItemCategoryController@edit')->name('audit.name.edit');
	Route::post('/audit-name/edit/{id}', 'AuditItemCategoryController@update')->name('audit.name.update');
	Route::get('/audit-name/remove/{id}', 'AuditItemCategoryController@remove')->name('audit.name.remove');

	# Auditables
	Route::get('/auditables', 'AuditableController@index')->name('auditables');
	Route::get('/auditable/{cat}/{id}/view-qr', 'AuditableController@viewQr')->name('auditable.view.qr');
	Route::get('/auditable/{cat}/{id}/download-qr', 'AuditableController@downloadQr')->name('auditable.download.qr');

	# Audit
	Route::get('/audit', 'AuditController@index')->name('audit.index');
	Route::get('/audit/qr', 'AuditController@qr')->name('audit.qr');
	# This will audit the auditables by marshal
	Route::get('/audit/{cat}/{id}', 'AuditController@audit')->name('audit');
	# Get Supervisor and Caretaker in Auditable
	Route::get('/auditable/assigned/supervisor/{cat}/{id}', 'AssignmentController@getSupervisors')->name('get.assigned.supervisors');
	Route::get('/auditable/assigned/caretaker/{cat}/{id}', 'AssignmentController@getCaretakers')->name('get.assigned.caretakers');

	Route::post('/audit/store', 'AuditController@store')->name('audit.store');
	Route::post('/audit/done/{id}', 'AuditController@auditDone')->name('audit.done');

	# Audit Review
	Route::get('/audit-review', 'AuditReviewController@index')->name('audit.review');
	Route::get('/audit-review/{id}', 'AuditReviewController@show')->name('audit.review.show');
	Route::post('/audit-review/{id}', 'AuditReviewController@review')->name('audit.post.review');
	Route::get('/audit/reviewed', 'AuditReviewController@reviewed')->name('audit.reviewed');
	// Route::get('/audit/reviewedby/{id}', 'AuditReviewController@reviewedby')->name('audit.reviewedby');
	Route::get('/auditor/review/{id}','AuditReviewController@auditorreview')->name('auditor.review');

	# Rerpots
	Route::get('/reports', 'ReportController@index')->name('reports');
	# Audit Marshal Reports
	Route::get('/report/audit-marshal', 'ReportController@marshal')->name('report.marshal');
	# Sample Export
	Route::get('/sample-export', 'ReportController@sampleExport');
	# First Audit Marshal Report Export
	Route::post('/report/audit-marshal', 'ReportController@postExportMarshal')->name('report.post.export.marshal');
	# Location Compliance|non compliance Reports
	Route::get('/report/location-compliance', 'ReportController@locationCompliance')->name('report.location.compliance');
	Route::post('/report/location-compliance', 'ReportController@postLocationCompliance')->name('report.post.location.compliance');
	# Load all audit item under the selected farm
	Route::get('/get/audit-item/farm/{id}', 'ReportController@getFarmAuditItems')->name('get.farm.audit.items');


	# Supervisor | Caretaker Report
	Route::get('/report/assigned-personnel', 'ReportController@assignedPersonnel')->name('report.assigned.personnel');
	Route::post('/report/assigned-personnel', 'ReportController@postAssignedPersonnel')->name('report.post.assigned.personnel');

	# Get Farm use for reports
	Route::get('/farms/get', 'ReportController@getFarms')->name('report.get.farms');
	# Get Location using farm_id
	Route::get('/farm/location/get/{id}', 'ReportController@getFarmLocation')->name('report.get.farm.location');
	# get sub loation using location id
	Route::get('/farm/sublocation/get/{id}', 'ReportController@getFarmSubLocation')->name('report.get.farm.sub.location');
	# get daily compliance and non compliance on location
	Route::get('/daily/loc/compliance/{id}', 'ReportController@dailyLocCompliance')->name('report.daily.loc.compliance');
	Route::get('/daily/sub/compliance/{id}', 'ReportController@dailySubCompliance')->name('report.daily.sub.compliance');


	# Audit Reviewer Notification | Make Global or over the site with reviwer access
	Route::get('/reviwer/notification', 'ReviewerNotificationController@notif')->name('reviewer.notification');

});

# Admin Route Group
Route::group(['prefix' => 'a', 'middleware' => 'admin'], function () {
	# Admin Dashboard
	Route::get('/dashboard/', 'AdminController@dashboard')->name('admin.dashboard');
	# Admin Profile
	Route::get('/profile', 'UserController@profile')->name('admin.profile');
	# Change Password
	Route::get('/change-password', 'UserController@changePassword')->name('admin.change.password');
	Route::post('/change-password', 'UserController@postChangePassword')->name('admin.post.change.password');
	# All Users
	Route::get('/users', 'AdminController@users')->name('admin.users');
	# Add user
	Route::get('/user/add', 'AdminController@addUser')->name('admin.add.user');
	Route::post('/user/add', 'AdminController@postAddUser')->name('admin.post.add.user');
	# Update user
	Route::get('/user/update/{id}', 'AdminController@updateUser')->name('admin.update.user');
	Route::post('/user/update/{id}', 'AdminController@postUpdateUser')->name('admin.post.update.user');
	# System Config
	Route::get('/system/config', 'ConfigurationController@index')->name('system.config');
	Route::post('/system/config', 'ConfigurationController@update')->name('system.config.update');
	# Access Assignment
	Route::get('/access', 'AccessController@index')->name('access');
	# Assign Access to Specific User
	Route::get('/user/{id}/set-access', 'AccessController@create')->name('set.access');
	Route::post('/user/{id}/set-access', 'AccessController@store')->name('post.set.access');

	# Database Backup
	Route::get('/database-backup', 'AdminController@database')->name('database.backup');
	# Database Backup Download
	Route::get('/database-backup/download/{id}', 'AdminController@databaseDownload')->name('database.download');

	# User Logs/ Audit Trail
	Route::get('/user-logs', 'UserLogController@index')->name('user.logs');

	# Farm Management
	Route::get('/farms', 'FarmController@index')->name('admin.farms');
	Route::get('/farm/add', 'FarmController@create')->name('farm.add');
	Route::post('/farm/add', 'FarmController@store')->name('farm.post.add');
	Route::get('/farm/edit/{id}', 'FarmController@edit')->name('farm.edit');
	Route::post('/farm/edit/{id}', 'FarmController@update')->name('farm.update');

});

# VP Route Group
Route::group(['prefix' => 'vp', 'middleware' => 'vp'], function () {
	Route::get('/', 'VpController@dashboard')->name('vp.dashboard');
});

# VP Route Group
Route::group(['prefix' => 'divhead', 'middleware' => 'divhead'], function () {
	Route::get('/', 'DivHeadController@dashboard')->name('divhead.dashboard');
});

# VP Route Group
Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function () {
	Route::get('/', 'ManagerController@dashboard')->name('manager.dashboard');
});

# VP Route Group
Route::group(['prefix' => 'sup', 'middleware' => 'supervisor'], function () {
	Route::get('/', 'SupervisorController@dashboard')->name('supervisor.dashboard');
});

# VP Route Group
Route::group(['prefix' => 'officer', 'middleware' => 'officer'], function () {
	Route::get('/', 'OfficerController@dashboard')->name('officer.dashboard');
});

# User Route Group
Route::group(['prefix' => 'u', 'middleware' => 'u'], function () {
	# User Dashboard
	Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');

});