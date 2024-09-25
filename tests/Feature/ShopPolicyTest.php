<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;

class ShopPolicyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;
    public function test_user_can_update_their_shop()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->assertTrue($user->can('update', $shop));
    }

    public function test_user_cannot_update_others_shop()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $shop = Shop::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2)
             ->assertFalse($user2->can('update', $shop));
    }
}
