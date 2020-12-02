<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    const PASSWORD = '123123123';
    /**
     * @var User
     */
    protected $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'mysql_test'])->run();
        $this->seedAdminUser();
    }

    public function tearDown() : void
    {
//        $this->artisan('migrate:rollback', ['--database' => 'mysql_test'])->run();

        parent::tearDown();
    }

    public function seedAdminUser() {
        $this->user = $this->app->make(User::class)->create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => self::PASSWORD
        ]);
    }
}
