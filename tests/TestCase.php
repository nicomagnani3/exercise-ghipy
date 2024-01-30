<?php

namespace Tests;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Http\Middleware\VerifyCsrfToken;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $user;
    protected function setUp(): void
    {
        parent::setup();
        $this->setUser();

        $this->withoutMiddleware([
            CheckClientCredentials::class,           
            VerifyCsrfToken::class,
        ]);
    }

    protected function setUser(): void
    {
        $this->user = User::factory()->create();
    }

    protected function getUser(): User
    {
        return User::first();
    }
}
