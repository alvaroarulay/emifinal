<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    Use RefreshDatabase;
 
    public function test_example()
    {
        $response = $this->get('/login');
        $response->assertStatus(status:200);
    }
    public function authenticated_to_a_user()
    {
       
        $this->get('/login')->assertSee('Login');
        $credentials = [
            "username" => "alvarolp",
            "password" => "610103434"
        ];

        $response = $this->post('/login', $credentials);
        $response->assertRedirect('/home');
        $this->assertCredentials($credentials);
    }
 
     
    public function not_authenticate_to_a_user_with_credentials_invalid()
    {
        $user = create('App\User', [
            "username" => "user@mail.com"
        ]);
        $credentials = [
            "username" => "users@mail.com",
            "password" => "secret"
        ];

        $this->assertInvalidCredentials($credentials);
    }

  
    public function the_email_is_required_for_authenticate()
    {
        $user = create('App\User');
        $credentials = [
            "username" => null,
            "password" => "secret"
        ];

        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')->assertSessionHasErrors([
            'username' => 'The email field is required.',
        ]);
    }

    
    public function the_password_is_required_for_authenticate()
    {
        $user = create('App\User', ['email' => 'zaratedev@gmail.com']);
        $credentials = [
            "username" => "zaratedev@gmail.com",
            "password" => null
        ];

        $response = $this->from('/login')->post('/login', $credentials);
        $response->assertRedirect('/login')
            ->assertSessionHasErrors([
                'password' => 'The password field is required.',
            ]);
    }
}
