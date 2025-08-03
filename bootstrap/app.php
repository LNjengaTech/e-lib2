<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CheckOverdueLoans;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register your custom middleware aliases here
        $middleware->alias([
            'user' => \App\Http\Middleware\UserMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class, // NEW: Register super_admin middleware
        ]);

        // You can also add global middleware or middleware groups here if needed
    })
    ->withCommands([
        CheckOverdueLoans::class,
    ])

    ->withSchedule(function (Schedule $schedule) {
        //define scheduled tasks in Laravel 12
        $schedule->command('loans:check-overdue')->everyMinute();
    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
