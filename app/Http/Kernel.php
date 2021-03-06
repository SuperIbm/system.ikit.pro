<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\LogAction::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            //\App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [

        ],

        'ajax' => [
            \App\Http\Middleware\AllowOnlyAjaxRequests::class
        ],

        'school' => [
            \App\Modules\School\Http\Middleware\SetSchool::class
        ],

        'locale' => [
            \App\Http\Middleware\Locale::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.api' => \App\Modules\Access\Http\Middleware\AllowOAuth::class,
        'auth.user' => \App\Modules\Access\Http\Middleware\AllowUser::class,
        'auth.guest' => \App\Modules\Access\Http\Middleware\AllowGuest::class,
        'auth.verified' => \App\Modules\Access\Http\Middleware\AllowVerified::class,
        'auth.role' => \App\Modules\Access\Http\Middleware\AllowRole::class,
        'auth.school' => \App\Modules\Access\Http\Middleware\AllowSchool::class,
        'auth.section' => \App\Modules\Access\Http\Middleware\AllowSection::class,
        'auth.limit' => \App\Modules\Access\Http\Middleware\AllowLimit::class,
        'auth.paid' => \App\Modules\Access\Http\Middleware\AllowPaid::class,
        'auth.trial' => \App\Modules\Access\Http\Middleware\AllowTrial::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
