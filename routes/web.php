<?php
use Illuminate\Support\Facades\Route;

Route::get('/ts', 'TestController@timestamp');
Route::get('/qr1', 'TestController@qr1');

Route::post('upload', 'TestController@upload')->name('upload');

Route::get('/qr', function () {
	return view('qr');
});

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
	Route::get('/audit-item/edit/{id}', 'AuditItemcontroller@edit')->name('audit.item.edit');
	Route::get('/audit-item/remove/{id}', 'AuditItemcontroller@remove')->name('audit.item.remove');

	# Auditables
	Route::get('/auditables', 'Auditablecontroller@index')->name('auditables');
	Route::get('/auditable/{cat}/{id}/view-qr', 'Auditablecontroller@viewQr')->name('auditable.view.qr');
	Route::get('/auditable/{cat}/{id}/download-qr', 'Auditablecontroller@downloadQr')->name('auditable.download.qr');

	# Audit
	Route::get('/audit', 'AuditController@index')->name('audit.index');
	Route::get('/audit/qr', 'AuditController@qr')->name('audit.qr');
	# This will audit the auditables by marshal
	Route::get('/audit/{cat}/{id}', 'AuditController@audit')->name('audit');
	# Get Supervisor and Caretaker in Auditable
	Route::get('/auditable/assigned/supervisor/{cat}/{id}', 'AssignmentController@getSupervisors')->name('get.assigned.supervisors');
	Route::get('/auditable/assigned/caretaker/{cat}/{id}', 'AssignmentController@getCaretakers')->name('get.assigned.caretakers');

	Route::post('/audit/store', 'AuditController@store')->name('audit.store');

	# Audit Review
	Route::get('/audit-review', 'AuditReviewController@index')->name('audit.review');

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
	# Access Assignment
	Route::get('/access', 'AccessController@index')->name('access');
	# Assign Access to Specific User
	Route::get('/user/{id}/set-access', 'AccessController@create')->name('set.access');
	Route::post('/user/{id}/set-access', 'AccessController@store')->name('post.set.access');

	# Database Backup
	Route::get('/database-backup', 'AdminController@database')->name('database.backup');

	# User Logs/ Audit Trail
	Route::get('/user-logs', 'UserLogController@index')->name('user.logs');
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