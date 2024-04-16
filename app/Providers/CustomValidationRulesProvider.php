<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationRulesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        Validator::extend('matches_student_id', function ($attribute, $value, $parameters, $validator) {
            return \App\Models\StudentID::where('student_no', $value)->exists();
        });
        
    }
}
