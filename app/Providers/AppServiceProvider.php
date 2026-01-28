<?php

namespace App\Providers;

use App\Models\Applicant;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share([
            'totalApplicants' => Applicant::count(),
            'totalPending' => Applicant::where('status', 'pending')->count(),
            'totalScheduled' => Applicant::where('status', 'interview_scheduled')->count(),
            'totalRejected' => Applicant::where('status', 'rejected')->count(),
        ]);
    }
}
