<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
    public function boot()
    {
        // Define the custom validation rule
        Validator::extend('contactno', function ($attribute, $value, $parameters, $validator) {
            // Custom validation logic (e.g., a 10-digit phone number)
            return preg_match('/^[0-9]{10}$/', $value);
        });

        // Optionally, define a custom error message
        Validator::replacer('contactno', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute must be a valid contact number.');
        });

        Paginator::useBootstrapFive();
    }
}
