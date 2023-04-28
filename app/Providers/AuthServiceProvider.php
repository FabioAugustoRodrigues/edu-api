<?php

namespace App\Providers;

use App\Policies\ContentPolicy;
use App\Policies\CoursePolicy;
use App\Policies\EnrollmentPolicy;
use App\Policies\LessonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // COURSE POLICY
        Gate::define("teacher-update-course", [CoursePolicy::class, "update"]);
       
        // LESSON POLICY
        Gate::define('teacher-store-course-lessons', [LessonPolicy::class, 'store']);
        Gate::define('teacher-update-lesson-name', [LessonPolicy::class, 'updateName']);
        Gate::define('teacher-update-lesson-orders', [LessonPolicy::class, 'updateOrder']);

        // CONTENT POLICY
        Gate::define('teacher-store-lesson-contents', [ContentPolicy::class, 'store']);
        Gate::define('teacher-update-lesson-contents', [ContentPolicy::class, 'update']);
        Gate::define('teacher-view-all-lesson-contents', [ContentPolicy::class, 'viewAll']);

        // ENROLLMENT POLICY
        Gate::define("teacher-view-course-enrollments", [EnrollmentPolicy::class, "view"]);
    }
}
