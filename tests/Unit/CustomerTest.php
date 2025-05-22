<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;
use App\Models\User;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_customer_and_related_user()
    {
        // Arrange - data input
        $data = [
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'password' => 'secret123',
            'profile_photo' => 'profile.jpg',
            'locations' => 'Bandung',
        ];

        // Act - panggil fungsi static createWithUser
        $customer = Customer::createWithUser($data);

        // Assert - data customer berhasil dibuat
        $this->assertDatabaseHas('customers', [
            'username' => 'johndoe',
            'email' => 'johndoe@example.com',
            'profile_photo' => 'profile.jpg',
            'locations' => 'Bandung',
        ]);

        // Assert - data user juga berhasil dibuat
        $this->assertDatabaseHas('users', [
            'name' => 'johndoe',
            'email' => 'johndoe@example.com',
            'role' => 'customer',
            'userable_id' => $customer->id,
            'userable_type' => Customer::class,
        ]);

        // Optional: cek relasi
        $this->assertInstanceOf(User::class, $customer->user);
        $this->assertEquals('johndoe', $customer->user->name);
    }
}
