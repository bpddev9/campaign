<?php

use App\Http\Controllers\Api\Profile\UserProfileController;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumePreviewController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\EmploymentController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Campaign\JobsController;
use App\Http\Controllers\Api\Auth\EmailVerifyController;
use App\Http\Controllers\Api\Auth\SocialLoginController;
use App\Http\Controllers\Api\Campaign\ProfileController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\Profile\Resume\UploadController;
use App\Http\Controllers\Api\Profile\ApplicantProfileController;
use App\Http\Controllers\Api\Profile\Resume\Manual\MyLinkController;
use App\Http\Controllers\Api\Profile\Resume\Manual\CertAwardController;
use App\Http\Controllers\Api\Profile\Resume\Manual\ExperienceController;
use App\Http\Controllers\Api\Profile\Resume\Manual\PublicationController;
use App\Http\Controllers\Api\Profile\Resume\Manual\EduQualificationController;
use App\Http\Controllers\Api\Profile\Resume\Manual\SkillController;

Route::middleware(['auth:sanctum', 'is.verified'])->get('/user', function (Request $request) {
    return new UserResource($request->user()->load('resume'));
});

// User Authentication
Route::group(['prefix' => 'auth'], function () {
    Route::post('sign-in', LoginController::class);
    Route::post('sign-up', RegisterController::class);
    Route::post('email-verify', [EmailVerifyController::class, 'verify']);
    Route::post('resend-code', [EmailVerifyController::class, 'resend']);
    Route::post('social-login', SocialLoginController::class);
    Route::post('sign-out', LogoutController::class)->middleware('auth:sanctum');

    // forgot password
    Route::post('forgot-password', [PasswordResetController::class, 'forgot']);
    Route::post('verify-email', [PasswordResetController::class, 'verify']);
    Route::post('reset-password', [PasswordResetController::class, 'reset']);
});

// user account
Route::group(['middleware' => ['auth:sanctum', 'is.verified'], 'prefix' => 'my-account'], function () {
    // applicant account
    Route::middleware(['user.role:applicant'])->group(function () {
        Route::group(['prefix' => 'profile'], function () {

            // applicant profile
            Route::get('/', [ApplicantProfileController::class, 'index']);
            Route::post('/update', [ApplicantProfileController::class, 'update']);

            Route::group(['prefix' => 'resume'], function () {

                // applicant resume upload
                Route::get('/', [UploadController::class, 'index']);
                Route::post('/store', [UploadController::class, 'store']);

                // applicant manual resume: work-experience
                Route::group(['prefix' => 'work-experience'], function () {
                    Route::get('/', [ExperienceController::class, 'index']);
                    Route::post('/store', [ExperienceController::class, 'store']);
                    Route::delete('/{experience}/delete', [ExperienceController::class, 'destroy']);
                });

                // applicant manual resume: education/qualification
                Route::group(['prefix' => 'edu-qualification'], function () {
                    Route::get('/', [EduQualificationController::class, 'index']);
                    Route::post('/store', [EduQualificationController::class, 'store']);
                    Route::delete('/{qualification}/delete', [EduQualificationController::class, 'destroy']);
                });

                // applicant manual resume: publication
                Route::group(['prefix' => 'publication'], function () {
                    Route::get('/', [PublicationController::class, 'index']);
                    Route::post('/store', [PublicationController::class, 'store']);
                    Route::delete('/{publication}/delete', [PublicationController::class, 'destroy']);
                });

                // applicant manual resume: certification/award
                Route::group(['prefix' => 'cert-award'], function () {
                    Route::get('/', [CertAwardController::class, 'index']);
                    Route::post('/store', [CertAwardController::class, 'store']);
                    Route::delete('/{certification}/delete', [CertAwardController::class, 'destroy']);
                });

                // applicant manual resume: skill
                Route::group(['prefix' => 'skill'], function () {
                    Route::get('/', [SkillController::class, 'index']);
                    Route::post('/store', [SkillController::class, 'store']);
                    Route::delete('/{skill}/delete', [SkillController::class, 'destroy']);
                });

                // applicant links
                Route::group(['prefix' => 'links'], function () {
                    Route::get('/', [MyLinkController::class, 'index']);
                    Route::post('/store', [MyLinkController::class, 'store']);
                    Route::delete('/{id}/delete', [MyLinkController::class, 'destroy']);
                });
            });
        });

        // applicant employments
        Route::prefix('employments')->group(function () {
            Route::get('/', [EmploymentController::class, 'index']);
            Route::get('/{id}', [EmploymentController::class, 'show']);
            Route::post('/{id}/apply', [EmploymentController::class, 'jobApply'])->middleware('can.apply');
            Route::get('/applied/jobs', [EmploymentController::class, 'appliedJobs']);
            Route::post('/{id}/save', [EmploymentController::class, 'saveJob']);
            Route::get('/saved/jobs', [EmploymentController::class, 'allSavedJob']);
        });
    });

    // campaign account
    Route::middleware(['user.role:campaign'])->prefix('campaign')->group(function () {
        // campaign profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index']);
            Route::post('/store', [ProfileController::class, 'store']);
        });

        // campaign jobs
        Route::prefix('jobs')->group(function () {
            Route::get('/', [JobsController::class, 'index']);
            Route::get('/infos', [JobsController::class, 'infos']);
            Route::get('/{id}', [JobsController::class, 'show']);
            Route::post('store-title', [JobsController::class, 'storeTitle']);
            Route::post('/store', [JobsController::class, 'store']);

            Route::get('/questions/{job_id}', [JobsController::class, 'jobQuestions']);

            Route::post('/store-question', [JobsController::class, 'storeQuestion']);

            // campaign applicants list for a single job
            Route::prefix('applied')->group(function () {
                Route::get('/{jobid}', [JobsController::class, 'applied']);
                Route::get('/resume/{userid}', [JobsController::class, 'userResume']);
                Route::get('/answer/{applied_job_id}', [JobsController::class, 'userAnswer']);
                Route::delete('/remove/{applied_job_id}', [JobsController::class, 'removeApplicant']);
            });
        });

        // campaign applicants list
        Route::get('/job-applicants', [JobsController::class, 'appliedUsers']);
        Route::get('/applied-jobs/{user_id}', [JobsController::class, 'appliedJobs']);

        // Message to Applicant
        Route::prefix('message')->group(function () {
            Route::post('/send', [MessageController::class, 'sendMessage']);
        });
    });

    Route::get('resume-preview/{user_id?}', [ResumePreviewController::class, 'preview']);
    Route::post('/profile/password-update', [UserProfileController::class, 'passwordUpdate']);
});
