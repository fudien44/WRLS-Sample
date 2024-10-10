<?php

use App\Models\User;
use App\Models\Client;
use App\Mail\SampleEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AttachController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AlertNotification;
use App\Http\Controllers\EncoderController;
use App\Http\Controllers\initappController;
use App\Http\Controllers\operappController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\SampleInspectorController;
use App\Http\Controllers\RolesandPermissionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\emailcontroller\InitialEmailCtrl;
use App\Http\Controllers\emailcontroller\OperationalEmailCtrl;




//carl's routes--------------------------------------------------------------------------------------------

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/login', function () {
    return view('/auth/login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('logout', function(){
    auth()->logout();
    return to_route('login');
});

//  RELATED TO INITIAL APPLICATIONS-------------------------------------------------------------------------------------------------------
Route::get('/Initial', function () {
    return view('Initial');
})->middleware(['auth', 'verified'])->name('Initial');

//under initial folder routes
Route::get('/initial-wrs', [initappController::class, 'showForm'])->middleware(['auth', 'verified'])->name('initial-wrs.show');
Route::post('/initial-wrs', [initappController::class, 'handleForm'])->middleware(['auth', 'verified'])->name('initial-wrs.submit');
Route::get('/cemetery', function () {
    return view('/initial/initial_cemetery');
})->name('cemetery');
Route::get('/funeral', function () {
    return view('/initial/initial_funeral');
})->name('funeral');

//initial transactions
Route::get('initial_transact', [initappController::class, 'indextable'])->middleware(['auth', 'verified'])->name('initialtransact');

//delete initial application
Route::delete('/facility/{fac_id}', [initappController::class, 'delete'])->name('facility.delete');

//generate application forms
Route::get('initial-pdf/{fac_id}', [AttachController::class, 'generatePdfinitial'])->name('initialform');

//upload signed application forms
Route::post('initial-form-upload', [AttachController::class, 'handleInitialApplicationFormUpload'])->name('initialform.upload');

//generate order of payment forms
Route::get('orderpayment-wrs/{fac_id}', [AttachController::class, 'generateOrderofPayment'])->name('orderpayment.wrs');

//for reupload of attachments
Route::post('/reupload-attachments', [AttachController::class, 'handleReuploadInitial'])->middleware(['auth', 'verified'])->name('attachments.reupload');

//for upload of initial permit
Route::post('/upload-initialpermit', [AttachController::class, 'InitialPermitupload'])->middleware(['auth', 'verified'])->name('initialpermit.upload');

//for upload of payment of order
Route::post('/upload-orderpayment', [AttachController::class, 'handlePaymentupload'])->middleware(['auth', 'verified'])->name('orderpaymentupload');

// initial permit print
Route::get('initial-permit/{fac_id}', [AttachController::class, 'generateInitialPermit'])->name('initialpermit');

//under initial folder routes 
Route::get('/waterrefilling', function () {
    return view('/initial/initial_wrs');
})->name('waterrefilling');

Route::get('/cemetery', function () {
    return view('/initial/initial_cemetery');
})->middleware(['auth', 'verified'])->name('cemetery');

Route::get('/funeral', function () {
    return view('/initial/initial_funeral');
})->middleware(['auth', 'verified'])->name('funeral');

//evaluation of Initial attachments
Route::post('/attachments/validate', [AttachController::class, 'validateinitAttachment'])->name('attachments.validate');
Route::post('/attachments/reject', [AttachController::class, 'rejectinitAttachment'])->name('attachments.reject');

//evaluation of Operational attachments
Route::post('/operattachments/validate', [AttachController::class, 'validateoperAttachment'])->name('operattachments.validate');
Route::post('/operattachments/reject', [AttachController::class, 'rejectoperAttachment'])->name('operattachments.reject');

//email routes---------------------------------------------------------------------------------------------------------
//initial email route
Route::post('/email-payment', [InitialEmailCtrl::class, 'paymentEmail'])->name('email.orderpayment');
Route::post('/email-reattach', [InitialEmailCtrl::class, 'reattachEmail'])->name('email.reattach');
Route::post('/email-inspection', [InitialEmailCtrl::class, 'paymentInspection'])->name('email.inspection');
Route::post('/email-issuance', [InitialEmailCtrl::class, 'issuanceEmail'])->name('email.issuance');
Route::post('/email-initpermit', [InitialEmailCtrl::class, 'initialpermit'])->name('email.initial');
//operational email route
Route::post('/email-opereattach', [OperationalEmailCtrl::class, 'reattachEmail'])->name('email.opereattach');
Route::post('/email-operainspection', [OperationalEmailCtrl::class, 'forInspection'])->name('email.operinspection');
Route::post('/email-operaissuance', [OperationalEmailCtrl::class, 'issuanceEmail'])->name('email.operissuance');
Route::post('/email-operapermit', [OperationalEmailCtrl::class, 'operationalpermit'])->name('email.operational');

//error 403
Route::get('/error404', function () {
    return view('error.403');
});

// Related Operational Application-------------------------------------------------------------------------------------------------------------------
Route::get('/operational', function () {
    return view('operational');
})->middleware(['auth', 'verified'])->name('operational');
//operational transaction
Route::get('operational_transact', [operappController::class, 'indextable'])->middleware(['auth', 'verified'])->name('operationaltransact');
//under operational folder routes
Route::get('/operational-wrs', [operappController::class, 'showForm'])->middleware(['auth', 'verified'])->name('operational-wrs.show');
Route::post('/operational-wrs', [operappController::class, 'handleForm'])->middleware(['auth', 'verified'])->name('operational-wrs.submit');
//delete operational application
Route::delete('/operapp/{fac_id}', [operappController::class, 'delete'])->name('operapp.delete');
//reupload attachments for operational
Route::post('/operationreupload-attachments', [AttachController::class, 'handleReuploadOperation'])->middleware(['auth', 'verified'])->name('operational.reupload');
// operational permit print
Route::get('operational-permit/{fac_id}', [AttachController::class, 'generateOperationalPermit'])->name('operationalpermit');
//generate operational application form
Route::get('operational-pdf/{fac_id}', [AttachController::class, 'generateOperaForm'])->name('operationalform');
//generate operational application form
Route::post('upload-operationalpermit', [AttachController::class, 'operationalPermitupload'])->name('operationalpermit.upload');
//upload signed application form
Route::post('operational-form-upload', [AttachController::class, 'handleOperationalApplicationFormUpload'])->name('operationalform.upload');





//----------------------------------------------------------------------------------------------------

//adam's routes------------------------------------------------------------------------------
// Route::get('/inspector', [InspectorController::class, 'index']);

// Route::get('/getapps', [InspectorController::class, 'index']);

//View Inspector page
Route::get('/inspector', function () {
    return view('inspection/inspector');
})->middleware(['auth', 'verified']);

Route::get('/inspection-not-visited', function(){
    return view('inspection/not-visited');
})->middleware(['auth', 'verified']);

Route::get('/inspection-overdue', function(){
    return view('inspection/overdue');
})->middleware(['auth', 'verified']);

Route::get('/facilities', function(){
    return view('inspection/utilities/facilities');
})->middleware(['auth', 'verified']);
//


//Retrieve data from controller to display on the DataTables in Inspector page
Route::get('/initapps', [InspectorController::class, 'initapps']);
Route::get('/opapps', [InspectorController::class, 'opapps']);

//Retrieve facilities that have been scheduled but not visited yet
Route::get('/pending', [InspectorController::class, 'pendingInspection']);

//Retrieves facilities that have been scheduled and are now overdue for inspection
Route::get('/overdue', [InspectorController::class, 'overdueInspection']);

//View the inspector's checklist form
Route::post('/get-checklist', [InspectorController::class, 'getChecklist']);

//View all list of facilities and its data
Route::get('/get-facilities', [InspectorController::class, 'facilitiesList']);

//Upload the inspector's checklist form
Route::post('/update-inspection/{inspectionID}', [InspectorController::class, 'updateInspection']);

//Schedule date of inspection in Initial Application
Route::put('set-initapp-inspection/{id}', [InspectorController::class, 'setInitAppInspection']);

//Schedule date of inspection in Operational Application
Route::put('set-opapp-inspection/{id}', [InspectorController::class, 'setOpAppInspection']);

//Reject the inspection in Initial Application
Route::put('reject-initapp-inspection/{id}', [InspectorController::class, 'rejectInitAppInspection']);

//Reject the inspection in Operational Application
Route::put('reject-opapp-inspection/{id}', [InspectorController::class, 'rejectOpAppInspection']);

//Get the initial attachment based on the initial application's id
Route::get('get-init-attachment/{id}', [AttachmentController::class, 'getInitAttachment']);

//Get the initial attachment based on the initial application's id
Route::get('get-op-attachment/{id}', [AttachmentController::class, 'getOpAttachment']);

//Get all attachment for application
Route::post('get-attachments', [AttachmentController::class, 'getAttachments']);

//Example only
Route::get('/sample', [SampleInspectorController::class, 'index']);


//Mail sending route
Route::post('/send-email', [EmailController::class, 'sendEmail']);

//Alert notification route
Route::get('/get-alerts', [AlertNotification::class, 'getAlerts']);

//Route for testing uploading file features
Route::get('/uploadfile', [UploadFileController::class, 'upload']);
Route::post('/uploadfile', [UploadFileController::class, 'uploadPost']);

//Route for testing viewing upload files features
Route::post('/viewtestfile', [AttachmentController::class, 'viewInitAttachment']);

//mikee's routes----------------------------------------------------------------------------------------
//sysadmin routes -------------------------------------------------------------
Route::get('/sysadmin', function () {
    return view('/layouts/sysadmin');
});

Route::resource('/roles', RoleController::class)->middleware(['auth', 'verified']);
//Route::post('/roles', [RoleController::class, 'validatePassword'])->name('verify.password');
// In routes/web.php or routes/api.php
Route::post('/verify-password', [RoleController::class, 'validatePassword'])->name('verify.password');// web.php
Route::post('roles/change-password', [RoleController::class, 'changePassword'])->name('roles.changePassword');






//-----------------------------------------------------------------------------------------------------------------
require base_path('routes/auth.php');

// Auth::routes();






