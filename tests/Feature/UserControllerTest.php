<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase; // Ensures the database is reset for each test

    /** @test */
    public function user_can_view_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this->post('/register', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create([
            'username' => 'existinguser',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'username' => 'existinguser',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_logout()
    {
        $this->actingAs(User::factory()->create());
        
        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
