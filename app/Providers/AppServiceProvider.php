<?php

namespace App\Providers;

use App\Application\Author\Repository\AuthorRepositoryInterface;
use App\Application\Book\BookService;
use App\Application\Book\Repository\BookRepositoryInterface;
use App\Application\Genre\Repository\GenreRepositoryInterface;
use App\Application\Logger\LoggerInterface;
use App\Application\User\Repository\UserRepositoryInterface;
use App\Repositories\AuthorRepository;
use App\Repositories\BookRepository;
use App\Repositories\GenreRepository;
use App\Repositories\UserRepository;
use App\Services\BookLogger;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->when(BookService::class)
                  ->needs(LoggerInterface::class)
                  ->give(BookLogger::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
