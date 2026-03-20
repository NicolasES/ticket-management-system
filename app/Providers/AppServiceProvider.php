<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->singleton(
            \App\Domain\Repositories\DepartmentRepository::class,
            \App\Infrastructure\Persistence\DepartmentRepository::class
        );

        $this->app->singleton(
            \App\Domain\Repositories\UserRepository::class,
            \App\Infrastructure\Persistence\UserRepository::class
        );

        $this->app->singleton(
            \App\Domain\Repositories\TicketRepository::class,
            \App\Infrastructure\Persistence\TicketRepository::class
        );

        // DAOs
        $this->app->singleton(
            \App\Application\DAOs\DepartmentDAO::class,
            \App\Infrastructure\DAOs\DepartmentDAO::class
        );

        $this->app->singleton(
            \App\Application\DAOs\UserDAO::class,
            \App\Infrastructure\DAOs\UserDAO::class
        );
        $this->app->singleton(
            \App\Application\DAOs\TicketDAO::class,
            \App\Infrastructure\DAOs\TicketDAO::class
        );

        // app - Services
        $this->app->singleton(
            \App\Application\Services\TokenGeneratorInterface::class,
            \App\Infrastructure\Services\SanctumTokenGenerator::class
        );

        // domain - Services
        $this->app->singleton(
            \App\Domain\Services\PasswordHasherInterface::class,
            \App\Infrastructure\Services\LaravelPasswordHasher::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
