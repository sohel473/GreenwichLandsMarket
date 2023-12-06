<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;


class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_admin_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertViewIs('admin.adminDashboard');
    }

    /** @test */
    public function admin_can_create_picture()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->post('/picture', [
            'name' => 'Test Picture',
            'description' => 'Test Description',
            'mainimage' => UploadedFile::fake()->image('default.jpg'),
            'price' => 100,
            'old_price' => 100
        ]);

        $response->assertRedirect('/picture/' . Product::first()->id);
        $this->assertCount(1, Product::all());
        $this->assertDatabaseHas('products', [
            'name' => 'Test Picture',
            'description' => 'Test Description',
            'price' => 100,
            'old_price' => 100
        ]);
    }


    /** @test */
    public function admin_can_edit_picture()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $picture = Product::factory()->create();

        $response = $this->put("/picture/{$picture->id}", [
            'name' => 'Updated Picture',
            'description' => 'Updated Description',
            'mainimage' => UploadedFile::fake()->image('default.jpg'),
            'price' => 100,
            'old_price' => 100
        ]);

        $updatedPicture = Product::first();
        $this->assertEquals('Updated Picture', $updatedPicture->name);
        $this->assertEquals('Updated Description', $updatedPicture->description);
        $response->assertRedirect('/picture/' . $picture->id);
    }


    /** @test */
    public function admin_can_delete_picture()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $picture = Product::factory()->create();

        $response = $this->delete("/picture/{$picture->id}");

        $this->assertCount(0, Product::all());
        $response->assertRedirect('/admin');
    }


    /** @test */
    public function admin_can_create_customer()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->post('/customer', [
            'username' => 'newcustomer',
            'email' => 'newcustomer@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(1, User::where('is_admin', false)->get());
        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('users', [
            'username' => 'newcustomer',
            'email' => 'newcustomer@example.com',
        ]);
    }


    /** @test */
    public function admin_can_edit_customer()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);
        $this->actingAs($admin);

        $response = $this->put("/customer/{$customer->id}", [
            'username' => 'updatedcustomer',
            'email' => 'updated@example.com',
        ]);

        $updatedCustomer = $customer->fresh();
        $this->assertEquals('updatedcustomer', $updatedCustomer->username);
        $this->assertEquals('updated@example.com', $updatedCustomer->email);
        $response->assertRedirect('/admin');
    }


    /** @test */
    public function admin_can_delete_customer()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['is_admin' => false]);
        $this->actingAs($admin);

        $response = $this->delete("/customer/{$customer->id}");

        $this->assertCount(0, User::where('is_admin', false)->get());
        $response->assertRedirect('/admin');
    }

    /** @test */
    public function admin_can_download_pictures_report()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/download-pictures-report');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /** @test */
    public function admin_can_download_customers_report()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/download-customers-report');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /** @test */
    public function admin_can_download_admins_report()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $response = $this->get('/download-admins-report');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    // ...additional test cases
}
