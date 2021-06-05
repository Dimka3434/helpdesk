<?php

namespace App\Providers;

use App\Services\ProblemService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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


        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $problemService = new ProblemService();
                $view->with('opened_problems_count', $problemService->getOpenedProblemsCount());
                $view->with('assigned_problems_count', $problemService->getAssignedProblemsCountByPerformerId(auth()->id()));
            } else {
                $view->with('opened_problems_count', 0);
                $view->with('assigned_problems_count', 0);
            }

        });
    }
}
