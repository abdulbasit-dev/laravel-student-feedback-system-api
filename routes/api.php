<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\{
    AuthController,
    EmailVerificationController,
    ForgetPasswordController
};

use App\Http\Controllers\Api\V1\{
    CollegeController,
    DepartmentController,
    UserProfileController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//API V1 
Route::group(['prefix' => 'v1'], function () {

    Route::get('test', function () {
        return 'test';
    });


    /*##################
       PUBLIC ROUTES
    ##################*/
    Route::post('/register-step1', [AuthController::class, 'registerStep1']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
    Route::resource('categories', CategoryController::class)->except('create', 'edit');

    //Forget Password
    Route::Post('forget-password', [ForgetPasswordController::class, 'forgetPassword']);
    Route::Post('validate-code', [ForgetPasswordController::class, 'validateCode']);
    Route::Post('new-password', [ForgetPasswordController::class, 'newPassword']);

    //Clear all cache
    Route::get('/clearallcache', function () {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('route:clear');
        Artisan::call('clear-compiled');

        return "ok";
    });

    //colleges
    Route::get('colleges/list', [CollegeController::class, 'list']);
    Route::apiResource('colleges', CollegeController::class);
    
    //departments
    Route::get('departments/list', [DepartmentController::class, 'list']);
    Route::apiResource('departments', DepartmentController::class);


    /*##################
      PROTECTED ROUTES
    ##################*/
    Route::group(['middleware' => ['auth:sanctum']], function () {
        //Auth
        Route::post('/register-step2', [AuthController::class, 'registerStep2'])->middleware('verified');
        Route::post('/logout', [AuthController::class, 'logout']);

        //Email Verify
        Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
        Route::post('email/check-verification', [EmailVerificationController::class, 'checkVerification']);
        //reset password
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('errorbag');;

        //forget password
        Route::Post('validate-code', [ForgetPasswordController::class, 'validateCode']);
        Route::Post('new-password', [ForgetPasswordController::class, 'forgetPassword']);

        //User Profile
        Route::get('/user-profiles', [UserProfileController::class, 'index']);
        Route::get('/user-profiles/{user}', [UserProfileController::class, 'userProfileById'])->name('user.profile');
        Route::put('/user-profiles', [UserProfileController::class, 'update']);
    });
});
