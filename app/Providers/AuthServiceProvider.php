<?php

namespace App\Providers;

use App\Models\Book;
use App\Policies\BookPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Массив зарегистрированных политик.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class => BookPolicy::class,
    ];

    /**
     * Регистрация политик приложения.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
