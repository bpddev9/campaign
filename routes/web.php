<?php

use App\Http\Controllers\AppliedJobController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\Resume\Manual\{
    AwardController,
    CertifiController,
    EducationController,
    PublicateController,
    WorkexpController
};
use Illuminate\Http\Request;

/**
 * User authentication steps
 */

Route::get('/', [\App\Http\Controllers\Auth\AuthenticateController::class, 'index'])->name('authenticate');

Route::get('/reset-password/{email}/{token}', [\App\Http\Controllers\Auth\AuthenticateController::class, 'resetview'])->name('reset.view');

Route::group(['prefix' => 'authenticate'], function () {

    Route::get('/verify', [\App\Http\Controllers\Auth\AuthenticateController::class, 'verification'])->name('verify.otp');
    Route::post('/register', [\App\Http\Controllers\Auth\AuthenticateController::class, 'register'])->name('auth.register');
    Route::get('/verify-email/{email}/{token}', [\App\Http\Controllers\Auth\AuthenticateController::class, 'verifyEmail'])->name('auth.verify.email');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticateController::class, 'login'])->name('auth.login');
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticateController::class, 'logout'])->name('auth.logout');
    Route::post('/forgot', [\App\Http\Controllers\Auth\AuthenticateController::class, 'forgot'])->name('auth.forgot');
    Route::post('/reset', [\App\Http\Controllers\Auth\AuthenticateController::class, 'reset'])->name('auth.reset');

    Route::group(['prefix' => 'social-login'], function () {
        Route::get('/{service}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirect']);
        Route::get('/{service}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'callback']);
    });
});

/**
 * Swagger Api Docs
 */
Route::view('/api-docs', 'api_doc');

/**
 * User dashboard after successfull authentication
 */
Route::group(['middleware' => ['auth', 'is.verified'], 'prefix' => 'my-account'], function () {
    Route::get('/', \App\Http\Controllers\Account\MyAccountController::class)->name('my.account');

    /**
     * Profile Questions; For Campaign & Applicant
     */
    Route::get('/profile-question', [\App\Http\Controllers\Account\ProfileQuestionController::class, 'index'])->name('profile.question');
    Route::post('/profile-question', [\App\Http\Controllers\Account\ProfileQuestionController::class, 'store'])->name('profile.question.store');

    Route::group(['middleware' => 'user.role:applicant'], function () {
        /**
         * Applicant View Profile
         */
        Route::get('/profile/applicant', \App\Http\Controllers\Account\ApplicantProfileController::class)->name('applicant.view.profile');

        /**
         * Applicant Edit Profile
         */
        Route::get('/profile', [\App\Http\Controllers\Account\MyProfileController::class, 'index'])->name('my.profile');
        Route::post('/profile', [\App\Http\Controllers\Account\MyProfileController::class, 'update'])->name('my.profile.update');

        Route::post('/confirm', [\App\Http\Controllers\Account\MyProfileController::class, 'confirm']);

        /**
         * Routes for job listing and single job details
         */
        Route::view('/all-jobs', 'jobs.listing')->name('jobs.listing');
        Route::get('/jobs-listing', \App\Http\Controllers\Job\JobListingController::class)->name('jobs.listing.ajax');
        Route::get('/job/{job}', \App\Http\Controllers\Job\JobSingleController::class)->name('job.single');

        Route::get('/applied-jobs', [AppliedJobController::class, 'index'])->name('applied.job');


        /**
         * Applicants resume management
         */
        Route::group(['prefix' => 'manage-resume'], function () {
            Route::view('/', 'account.resume.index')->name('manage.resume');
            Route::view('/upload', 'account.resume.upload_resume')->name('resume.upload');
            // Correction
            Route::prefix('/manual')->name('manual.')->group(function () {
                Route::get('/work-experiences', [WorkExpController::class, 'index'])->name('work-experience');
                Route::post('/work-experience/store', [WorkExpController::class, 'store'])->name('work-experience.store');
                Route::get('/work-experience/{id}/edit', [WorkExpController::class, 'edit'])->name('work-experience.edit');
                Route::get('/work-experience/{id}/delete', [WorkExpController::class, 'delete'])->name('work-experience.delete');

                Route::get('/educations', [EducationController::class, 'index'])->name('education');
                Route::post('/education/store', [EducationController::class, 'store'])->name('education.store');
                Route::get('/education/{id}/edit', [EducationController::class, 'edit'])->name('education.edit');
                Route::get('/education/{id}/delete', [EducationController::class, 'delete'])->name('education.delete');

                Route::get('/certifications', [CertifiController::class, 'index'])->name('certification');
                Route::post('/certification/store', [CertifiController::class, 'store'])->name('certification.store');
                Route::get('/certification/{id}/edit', [CertifiController::class, 'edit'])->name('certification.edit');
                Route::get('/certification/{id}/delete', [CertifiController::class, 'delete'])->name('certification.delete');

                Route::get('/publications', [PublicateController::class, 'index'])->name('publication');
                Route::post('/publication', [PublicateController::class, 'store'])->name('publication.store');
                Route::get('/publication/{id}/edit', [PublicateController::class, 'edit'])->name('publication.edit');
                Route::get('/publication/{id}/delete', [PublicateController::class, 'delete'])->name('publication.delete');

                Route::get('/awards', [AwardController::class, 'index'])->name('award');
                Route::post('/award/store', [AwardController::class, 'store'])->name('award.store');
                Route::get('/award/{id}/edit', [AwardController::class, 'edit'])->name('award.edit');
                Route::get('/award/{id}/delete', [AwardController::class, 'delete'])->name('award.delete');

                Route::get('/links', [\App\Http\Controllers\Account\Resume\Manual\LinkController::class, 'index'])->name('links');
                Route::post('/links/store', [\App\Http\Controllers\Account\Resume\Manual\LinkController::class, 'store'])->name('links.store');
                Route::get('/links/{id}/edit', [\App\Http\Controllers\Account\Resume\Manual\LinkController::class, 'edit'])->name('links.edit');
                Route::delete('/links/{id}/delete', [\App\Http\Controllers\Account\Resume\Manual\LinkController::class, 'destroy'])->name('links.destroy');
            });

            Route::view('/manual', 'account.resume.manual_resume')->name('resume.manual');
            Route::get('/fetch-resume', [\App\Http\Controllers\Account\ResumeUploadController::class, 'index'])->name('resume.fetch');
            Route::post('/upload', [\App\Http\Controllers\Account\ResumeUploadController::class, 'store'])->name('resume.upload.store');

            Route::group(['prefix' => 'work-experience'], function () {
                Route::get('/', [\App\Http\Controllers\Account\Resume\WorkExpController::class, 'index'])->name('work.exp.index');
                Route::get('/single/{param}', [\App\Http\Controllers\Account\Resume\WorkExpController::class, 'single'])->name('work.exp.single');
                Route::post('/store', [\App\Http\Controllers\Account\Resume\WorkExpController::class, 'store'])->name('work.exp.store');
                Route::delete('/delete/{experience}', [\App\Http\Controllers\Account\Resume\WorkExpController::class, 'destroy'])->name('work.exp.destroy');
            });

            Route::group(['prefix' => 'qualification'], function () {
                Route::get('/', [\App\Http\Controllers\Account\Resume\QualificationController::class, 'index'])->name('qualification.index');
                Route::post('/store', [\App\Http\Controllers\Account\Resume\QualificationController::class, 'store'])->name('qualification.store');
                Route::delete('/{qualification}/delete', [\App\Http\Controllers\Account\Resume\QualificationController::class, 'destroy'])->name('qualification.destroy');
            });

            Route::group(['prefix' => 'certification'], function () {
                Route::get('/', [\App\Http\Controllers\Account\Resume\CertificationController::class, 'index'])->name('certification.index');
                Route::post('/store', [\App\Http\Controllers\Account\Resume\CertificationController::class, 'store'])->name('certification.store');
                Route::delete('/{certification}/delete', [\App\Http\Controllers\Account\Resume\CertificationController::class, 'destroy'])->name('certification.destroy');
            });

            Route::group(['prefix' => 'publication'], function () {
                Route::get('/', [\App\Http\Controllers\Account\Resume\PublicationController::class, 'index'])->name('publication.index');
                Route::post('/store', [\App\Http\Controllers\Account\Resume\PublicationController::class, 'store'])->name('publication.store');
                Route::delete('/{publication}/delete', [\App\Http\Controllers\Account\Resume\PublicationController::class, 'destroy'])->name('publication.destroy');
            });
        });
    });

    Route::group(['middleware' => 'user.role:campaign'], function () {
        Route::view('manage-job', 'campaign.manage_job')->name('manage.job');
        Route::view('job-menu', 'campaign.jobs_menu')->name('jobs.menu');

        /**
         * Campaign View Profile
         */
        Route::get('/profile/campaign', \App\Http\Controllers\Campaign\ProfileController::class)->name('campaign.view.profile');

        /**
         * Applicant Profile Questions
         */
        Route::view('/applicant-question', 'campaign.profile.applicant_question')->name('applicant.questions.index');
        Route::post('/applicant-question', \App\Http\Controllers\Campaign\ApplicantQuestionController::class)->name('applicant.questions.store');

        /**
         * Employer Company profile management
         */
        Route::group(['prefix' => 'company-profile'], function () {
            Route::get('/', [\App\Http\Controllers\Campaign\CompanyProfileController::class, 'index'])->name('company.profile');
            Route::post('/store', [\App\Http\Controllers\Campaign\CompanyProfileController::class, 'store'])->name('company.profile.store');
        });

        /**
         * Employer Job Listing Management
         */
        Route::group(['prefix' => 'my-jobs'], function () {
            Route::get('/', [\App\Http\Controllers\Campaign\JobsController::class, 'index'])->name('jobs.index');
            Route::get('/create', [\App\Http\Controllers\Campaign\JobsController::class, 'create'])->name('jobs.create');
            Route::post('/create', [\App\Http\Controllers\Campaign\JobsController::class, 'store'])->name('jobs.store');
            Route::get('/{job}/edit', [\App\Http\Controllers\Campaign\JobsController::class, 'edit'])->name('job.edit');
            Route::patch('/{job}/edit', [\App\Http\Controllers\Campaign\JobsController::class, 'update'])->name('job.update');
            Route::delete('/{job}/delete', [\App\Http\Controllers\Campaign\JobsController::class, 'destroy'])->name('job.destroy');
            Route::get('/applied/{job}', [\App\Http\Controllers\Campaign\JobsController::class, 'applied'])->name('job.applied');
            Route::get('/job-applicants', [\App\Http\Controllers\Campaign\JobsController::class, 'jobApplicants'])->name('job.applicants');
        });
    });
});

Route::view('mail', 'emails.job-application');
