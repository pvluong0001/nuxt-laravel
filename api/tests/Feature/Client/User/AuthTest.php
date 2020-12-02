<?php

namespace Tests\Feature\Client\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUserCannotGetTokenAfterRegister() {
        $userInfo = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $this->faker->password
        ];

        Auth::shouldReceive('userResolver')->once()->andReturn(function(){});
        Auth::shouldReceive('guard')->with('client')->once()->andReturnSelf();
        Auth::shouldReceive('attempt')->with($userInfo)->once()->andReturn(null);

        $response = $this->json('POST', '/api/v1/auth/register', $userInfo);

        $response->assertStatus(401);
    }

    public function testUserCanRegisterWithValidCredentials() {
        $userInfo = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $this->faker->password
        ];

        $response = $this->json('POST', '/api/v1/auth/register', $userInfo);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('access_token', $data['data']);
        $this->assertDatabaseHas('users', Arr::except($userInfo, ['password']));
    }

    public function testUserCanLoginWithValidCredentials()
    {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);

        $response->assertStatus(200);
    }

    public function testUserCanNotLoginWithInvalidEmail() {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->faker->email,
            'password' => 'password_incorrect'
        ]);

        $response->assertStatus(422);
    }

    public function testUserCannotLoginWithWrongPassword() {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => 'password_incorrect'
        ]);

        $response->assertStatus(401);
    }

    public function testUserCanGetUserInfoAfterLogin() {
        // login action
        $loginResponse = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);

        $loginData = json_decode($loginResponse->getContent(), true);
        $loginResponse->assertStatus(200);

        $this->assertArrayHasKey('data', $loginData);
        $this->assertArrayHasKey('access_token', $loginData['data']);
        $accessToken = $loginData['data']['access_token'];

        // get info action
        $response = $this->json('POST', '/api/v1/auth/me', [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $userData = $data['data'];

        $this->assertEquals($userData['email'], $this->user->email);
    }

    public function testUserCanLogout() {
        // login action
        $loginResponse = $this->json('POST', '/api/v1/auth/login', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);

        $loginData = json_decode($loginResponse->getContent(), true);
        $loginResponse->assertStatus(200);

        $this->assertArrayHasKey('data', $loginData);
        $this->assertArrayHasKey('access_token', $loginData['data']);
        $accessToken = $loginData['data']['access_token'];

        // logout action
        $response = $this->json('POST', '/api/v1/auth/logout', [], [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertStatus(200);
    }
}
