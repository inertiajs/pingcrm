<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $account = Account::create(['name' => 'Acme Corporation']);

        $this->user = factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
    }

    public function test_can_view_restaurants()
    {
        $this->user->account->restaurants()->saveMany(
            factory(Restaurant::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/restaurants')
            ->assertStatus(200)
            ->assertPropCount('restaurants.data', 5)
            ->assertPropValue('restaurants.data', function ($restaurants) {
                $this->assertEquals(
                    [
                        'id', 'title','description', 'custmer_name',
                        'phone', 'custmer_order','custmer_address','restaurant_name', 'bill_no','feedback','payment_method'
                    ],
                    array_keys($restaurants[0])
                );
            });
    }

    public function test_can_search_for_restaurants()
    {
        $this->user->account->restaurants()->saveMany(
            factory(Restaurant::class, 5)->make()
        )->first()->update([
            'custmer_name' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/restaurants?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('restaurants.data', 1)
            ->assertPropValue('restaurants.data', function ($restaurants) {
                $this->assertEquals('Greg Andersson', $restaurants[0]['custmer_name']);
            });
    }

    public function test_cannot_view_deleted_restaurants()
    {
        $this->user->account->restaurants()->saveMany(
            factory(Restaurant::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/restaurants')
            ->assertStatus(200)
            ->assertPropCount('restaurants.data', 4);
    }

    public function test_can_filter_to_view_deleted_restaurants()
    {
        $this->user->account->restaurants()->saveMany(
            factory(Restaurant::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/restaurants?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('restaurants.data', 5);
    }

    public function test_can_view_single_restaurant()
    {
        $restaurant =  $this->user->account->restaurants()->saveMany(
            factory(Restaurant::class, 5)->make()
        )->first();

        //$restaurant = $restaurant->fresh();

        $this->actingAs($this->user)
            ->get('/restaurants/' . $restaurant->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('restaurant.custmer_name', $restaurant->custmer_name)
            ->assertPropValue('restaurant.phone', $restaurant->phone)
            ->assertPropValue('restaurant.custmer_order', $restaurant->custmer_order)
            ->assertPropValue('restaurant.custmer_address', $restaurant->custmer_address)
            ->assertPropValue('restaurant.bill_no', $restaurant->bill_no)
            ->assertPropValue('restaurant.feedback', $restaurant->feedback)
            ->assertPropValue('restaurant.payment_method', $restaurant->payment_method);



    }
}
