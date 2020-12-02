<?php

namespace Tests\Unit\Client\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthServiceTest extends \Tests\TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider additionProvider
     * @param array $data
     */
    public function testUserCanRegisterWithValidCredentials(array $data)
    {
        $service = app()->make(\App\Services\Client\AuthService::class);

        $service->register($data);
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
            'name' => $data['name']
        ]);
    }

    public function additionProvider(): array
    {
        return [
            [
                [
                    'email' => 'email1@test.com',
                    'password' => '123123123',
                    'name' => 'email1'
                ],
            ],
            [
                [
                    'email' => 'email2@test.com',
                    'password' => '123123123',
                    'name' => 'email2'
                ]
            ]
        ];
    }
}
