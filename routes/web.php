<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\landingPageController;
use App\Http\Controllers\tenant\tenantController;
use App\Http\Controllers\landlord\auth\landlordaccountprocessController;
use App\Http\Controllers\landlord\auth\dashboardController;
use App\Http\Controllers\landlord\auth\dormpageController;
use App\Http\Controllers\landlord\auth\roompageController;
use App\Http\Controllers\landlord\auth\bookingpageController;
use App\Http\Controllers\landlord\auth\messagelandlordController;

use App\Http\Controllers\landlord\auth\reservationController;
use App\Http\Controllers\landlord\auth\alltenantsController;
use App\Http\Middleware\LandlordAuth;

//view landingpage, login and register for landlord and tenant
Route::get('/', [landingPageController::class, 'landingPage'])->name('landingpage');
Route::get('/send-email', [landingPageController::class, 'sendEmail'])->name('send.email');
Route::get('/tenantLogin', [tenantController::class, 'login'])->name('login-tenant');
Route::get('/tenantRegister', [tenantController::class, 'register'])->name('register-tenant');
Route::get('/landlordLogin', [landlordaccountprocessController::class, 'landlordLogin'])->name('landlord-Login');
Route::post('/tenant-logout', [tenantController::class, 'logout'])->name('tenant.logout');
Route::post('/logout', [landlordaccountprocessController::class, 'logoutlandlord'])->name('logout');


Route::get('/landlordregister', [landlordaccountprocessController::class, 'landlordRegister'])->name('register-landlord');
//Route::get('/verify', [accountprocessController::class, 'startVerification'])->name('verify-otp');
Route::post('/verify-registration', [tenantController::class, 'verifyRegistration'])->name('verify.registration');
//creating tenants account

Route::match(['get', 'post'], '/SendOtp', [tenantController::class, 'SendOtp'])->name('SendOtp');
Route::match(['get', 'post'], '/resendOtp', [tenantController::class, 'resendOtp'])->name('resendOtp');
Route::match(['get', 'post'], '/registerTenant', [tenantController::class, 'registerTenant'])->name('registerTenant');
Route::match(['get', 'post'], 'tenant-login',[tenantController::class,'loginTenant'])->name('tenant-login');
//landlord login
Route::match(['get', 'post'], '/loginLandlord', [landlordaccountprocessController::class, 'loginLandlord'])->name('loginLandlord');



//landlord

Route::match(['get', 'post'], '/personalDetails', [landlordaccountprocessController::class, 'personalDetails'])->name('stepOne');
Route::post('/IdentityVerifaction', [landlordaccountprocessController::class, 'IdentityVerifaction'])->name('IdentityVerifaction');
Route::post('/businessPermitValidation', [landlordaccountprocessController::class, 'businessPermitValidation'])->name('businessPermitValidation');
Route::post('/RegisterLandlord', [landlordaccountprocessController::class, 'RegisterLandlord'])->name('RegisterLandlord');

//landlord auth

Route::middleware([LandlordAuth::class])->group(function () {
    Route::match(['get', 'post'], '/landlordDashboard/{landlordId}', [dashboardController::class, 'landlordDashboard'])->name('landlord.dashboard');
    Route::match(['get', 'post'], '/landlordDormManagement/{landlordId}', [dormpageController::class, 'DormManagement'])->name('landlord.dormanagement');
    Route::match(['get', 'post'], '/input-text', [dormpageController::class, 'inputFieldDorm'])->name('input-text');
    Route::match(['get', 'post'], '/upload-main-image', [dormpageController::class, 'uploadmainImage'])->name('upload-main-image');
    Route::match(['get', 'post'], '/upload-secondary-image', [dormpageController::class, 'uploadsecondaryImage'])->name('upload-secondary-image');
    Route::match(['get', 'post'], '/uplad-third-image', [dormpageController::class, 'uploadthirdImage'])->name('upload-third-image');
    Route::match(['get', 'post'], '/edit-main-image', [dormpageController::class, 'editmainImage'])->name('edit-main-image');
    Route::match(['get', 'post'], '/edit-secondary-image', [dormpageController::class, 'editsecondaryImage'])->name('edit-secondary-image');
    Route::match(['get', 'post'], '/edit-images/{id}', [dormpageController::class, 'imageUpdated'])->name('edit-images');
    Route::match(['get', 'post'], '/landlordRoomManagement/{landlordId}', [roompageController::class, 'RoomManagement'])->name('landlordRoomManagement');
 
    //functions for getting data dashboard 
    Route::get('/get/landlord/{landlord_id}', [dashboardController::class, 'getLandlord']);
    Route::get('/get/total-tenants/{landlord_id}', [dashboardController::class, 'getTotalTenants']);
    Route::get('/get/available-beds/{landlord_id}', [dashboardController::class, 'availableBeds']);
    Route::get('/get/reservation-list/{landlord_id}', [dashboardController::class, 'getReservationList']);
    Route::get('/get/booking-list/{landlord_id}', [dashboardController::class, 'getBookingList']);
    Route::get('/get/dorm-id/{landlord_id}', [dashboardController::class, 'getDormID']);
    Route::get('/get/room-profits/{landlord_id}', [dashboardController::class, 'getroomProfits']);
    Route::get('/get/gender-distribution/{landlord_id}', [dashboardController::class, 'getgenderDistribution']);
    Route::get('/generate-full-report/{landlordID}', [dashboardController::class, 'generateFullReport']);



    //functions for landlord dorm management
    Route::get('/getlandlordVerifiedStatus', [dormpageController::class, 'getlandlordVerifiedStatus'])->name('getlandlordVerifiedStatus');
    Route::post('/AddDorm', [dormpageController::class, 'AddDorm'])->name('AddDorm');
    Route::post('/UpdateDorm/{id}', [dormpageController::class, 'UpdateDorm']);
    Route::delete('/DeleteDorm/{id}', [dormpageController::class, 'DeleteDorm'])->name('DeleteDorm');
    Route::get('/ListDorms', [dormpageController::class, 'ListDorms'])->name('ListDorms');
    Route::get('/view-dorm/{id}', [dormpageController::class, 'ViewDorm']);
    Route::get('/SearchDorms', [dormpageController::class, 'searchDorms'])->name('SearchDorms');
    Route::get('/filter-locations', [dormpageController::class, 'filterLocations'])->name('filter.locations');
    Route::get('/filter-availability', [dormpageController::class, 'filteredAvailability'])->name('filter.availability');
    //functions for landlord dorm rules and policy
    Route::post('/add-rules', [dormpageController::class, 'addRulesAndPolicy'])->name('add.rules');
    Route::delete('/delete-rules/{pivotId}', [dormpageController::class, 'deleteRulesAndPolicies'])->name('delete.rules');
     //functions for amenities
     Route::post('/add-amenities', [dormpageController::class, 'AddAmenities'])->name('add.amenities');
     Route::delete('/delete-amenities/{id}', [dormpageController::class, 'DeleteAmenities'])->name('delete.amenities');
    //functions for landlord room management
    Route::post('/addRoom', [roompageController::class, 'addRoom'])->name('addRoom');
    Route::post('/add-roomfeatures', [roompageController::class, 'addRoomFeatures'])->name('add.roomfeatures');
    Route::delete('/delete-roomfeatures/{pivotId}', [roompageController::class, 'deleteRoomFeatures'])->name('delete.roomfeatures');
    Route::post('/update-room/{id}', [roompageController::class, 'UpdateRoom'])->name('update.room');
    // Route::post('/upload-images',[imagesDormImages::class,'roomImages'])->name('upload-images');
    Route::delete('/DeleteRoom/{id}', [roompageController::class, 'DeleteRoom'])->name('DeleteRoom');
    Route::get('/ListRooms', [roompageController::class, 'ListRooms'])->name('ListRooms');
    Route::get('/get-rooms-by-dorm/{dormId}', [roompageController::class, 'getRoomsByDorm'])->name('get.rooms.by.dorm');
    Route::get('/get-rooms-by-gender/{gender}', [roompageController::class, 'getRoomsByGender'])->name('get.rooms.by.gender');
    Route::get('/get-rooms-by-availability/{availability}', [roompageController::class, 'getRoomsByAvailability'])->name('get.rooms.by.availability');
    Route::get('/get-rooms-by-room-type', [roompageController::class, 'getRoomsByRoomType'])->name('get.rooms.by.room.type');
    Route::get('/ViewRoom/{id}', [roompageController::class, 'ViewRoom'])->name('ViewRoom');
    Route::get('/SearchRooms', [roompageController::class, 'searchRooms'])->name('SearchRooms');
    Route::post('/rooms/allow-reserve/{id}', [roompageController::class, 'allowReserve'])
     ->name('rooms.allowReserve');

    //functions for booking approval
   
    //functions for reservation 

    //functions for all tenants
 

    //functions for messaging landlord


    //functions for notfications landlord

  
});






Route::get('/test-auth', function () {
    return auth('landlord')->check() ? 'Authenticated as landlord' : 'NOT authenticated';
});



















