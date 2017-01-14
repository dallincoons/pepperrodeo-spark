<?php

namespace App\Providers;

use App\Repositories\Contracts\DepartmentRepository;
use App\Repositories\Contracts\RecipeCategoryRepository;
use App\Repositories\EloquentDepartmentRepository;
use App\Repositories\EloquentRecipeCategoryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DepartmentRepository::class, EloquentDepartmentRepository::class);
        $this->app->bind(RecipeCategoryRepository::class, EloquentRecipeCategoryRepository::class);
    }
}
