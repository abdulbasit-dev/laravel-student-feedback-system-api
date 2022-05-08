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
    LecturerController,
    PermissionController,
    RoleController,
    UserController,
    StudentController,
    SubjectController,
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

    /*##################
       PUBLIC ROUTES
    ##################*/

    Route::post('/login', [AuthController::class, 'login']);

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

    /*##################
      PROTECTED ROUTES
    ##################*/
    Route::group(['middleware' => ['auth:sanctum']], function () {

        //Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        //reset password
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('errorbag');;

        //User Profile
        Route::get('/user-profiles', [UserProfileController::class, 'index']);
        Route::get('/user-profiles/{user}', [UserProfileController::class, 'userProfileById'])->name('user.profile');
        Route::put('/user-profiles', [UserProfileController::class, 'update']);

        //colleges
        Route::get('colleges/list', [CollegeController::class, 'list']);
        Route::apiResource('colleges', CollegeController::class);

        //departments
        Route::get('departments/list', [DepartmentController::class, 'list']);
        Route::apiResource('departments', DepartmentController::class);

        //students
        Route::apiResource('students', StudentController::class)->parameters(['students' => 'user']);

        //lecturers
        Route::get('titles', [LecturerController::class, 'academicTitle']);
        Route::apiResource('lecturers', LecturerController::class);

        //subjects
        Route::apiResource('subjects', SubjectController::class);

        //users management
        Route::apiResource("users", UserController::class);

        //roles
        Route::get('roles/user-role/{user}', [RoleController::class, 'userRole']);
        Route::post('/roles/assign-user', [RoleController::class, 'assignRole']);
        Route::post('/roles/remove-user-role', [RoleController::class, 'removeRole']);
        Route::apiResource("roles", RoleController::class);

        //permissions
        Route::post('/permissions/assign-permissions-role', [PermissionController::class, 'assignPermissionsToRole']);
        Route::post('/permissions/remove-permissions-role', [PermissionController::class, 'removePermissionsFromRole']);
        Route::get("permissions", [PermissionController::class, 'index']);
    });

    //handle invalid routes
    Route::fallback(function () {
        return [
            'result' => false,
            'status' => 404,
            'message' => "invalid route",
        ];
    });
});
