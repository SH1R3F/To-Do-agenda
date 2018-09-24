<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class AuthenticateUsers extends TestCase
{
    public function test_success_response_on_login()
    {
        $user = \DB::table('users')->first();
        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ])->assertJson([
            'status' => 'success'
        ])->assertStatus(200);
    }

    public function test_success_response_on_registration()
    {
        $faker = (new Faker)::create();
        $this->postJson('/login', [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'secret'
        ])->assertJson([
            'status' => 'success'
        ])->assertStatus(200);
    }

}
