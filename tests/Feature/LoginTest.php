<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin() {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJsonFragment([
                'email' => [ 'The email field is required.' ],
                'password' => [ 'The password field is required.' ],
            ]);
    }

    public function testUserLoginsSuccessfully() {
        $user = factory(User::class)->create([
            'email' => 'offlisttest@mailinator.com',
            'password' => Hash::make('123123123'),
        ]);

        $payload = [
            'email' => 'offlisttest@mailinator.com',
            'password' => '123123123',
        ];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);
    }
}
