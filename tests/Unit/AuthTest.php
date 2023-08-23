<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register_with_valid_data()
    {
        Artisan::call('migrate:fresh');

        $response = $this->postJson('/api/v1/register',[
            "name" => "awaludin",
            "email" => "awaludin@gmail.com",
            "password" => "adminadmin"
        ]);
 
        $response->assertStatus(201)->assertJson([
            "status" => 201,
            "message" => "User successfully created!"
        ]);
    }

    public function test_register_with_missing_name() {
        $response = $this->postJson('/api/v1/register',[
            "email" => "awaludin1@gmail.com",
            "password" => "adminadmin"
        ]);
 
        $response->assertStatus(422)->assertJsonStructure([
            "errors" =>[
                'name'
            ]
        ]);
    }

    public function test_register_with_duplicated_email() {
        $response = $this->postJson('/api/v1/register',[
            "name" => "awaludin",
            "email" => "awaludin@gmail.com",
            "password" => "adminadmin"
        ]);

        $response->assertStatus(422)->assertJson([
            "errors" => [
                "email" => [
                    "The email has already been taken."
                ]
            ]
        ]);
    }

    public function test_login_with_valid_data() {
        $response = $this->postJson('/api/v1/login',[
            "email" => "awaludin@gmail.com",
            "password" => "adminadmin"
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            "status",
            "access_token",
            "token_type",
            "expires_in"
        ]);
    }

    public function test_login_with_wrong_credential() {
        $response = $this->postJson('/api/v1/login',[
            "email" => "wrong@gmail.com",
            "password" => "wrongpassword"
        ]);

        $response->assertStatus(401)->assertJson([
            "message" => "Credential Not Found",
            "status" => 401
        ]);
    }

    public function test_login_with_missing_email() {
        $response = $this->postJson('/api/v1/login',[
            "password" => "wrong"
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            "errors" =>[
                'email'
            ]
        ]);
    }

}
