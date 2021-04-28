<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressesTest extends TestCase
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

    public function test_can_view_addresses()
    {
        $this->user->account->addresses()->saveMany(
            factory(Address::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/addresses')
            ->assertStatus(200)
            ->assertPropCount('addresses.data', 5)
            ->assertPropValue('addresses.data', function ($addresses) {
                $this->assertEquals(
                    [
                        'id', 'name', 'phone','address_line1','address_line2','city',
                        'region','country','postal_code', 'deleted_at',
                    ],
                    array_keys($addresses[0])
                );
            });
    }

    public function test_can_search_for_addresses()
    {
        $this->user->account->addresses()->saveMany(
            factory(Address::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/addresses?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('addresses.data', 1)
            ->assertPropValue('addresses.data', function ($addresses) {
                $this->assertEquals('Greg Andersson', $addresses[0]['name']);
            });
    }

    public function test_cannot_view_deleted_addresses()
    {
        $this->user->account->addresses()->saveMany(
            factory(Address::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/addresses')
            ->assertStatus(200)
            ->assertPropCount('addresses.data', 4);
    }

    public function test_can_filter_to_view_deleted_addresses()
    {
        $this->user->account->addresses()->saveMany(
            factory(Address::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/addresses?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('addresses.data', 5);
    }

    public function test_can_view_single_address()
    {
        $address =  $this->user->account->addresses()->saveMany(
            factory(Address::class, 5)->make()
        )->first();

        //$address = $address->fresh();

        $this->actingAs($this->user)
            ->get('/addresses/' . $address->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('address.name', $address->name)
            ->assertPropValue('address.phone', $address->phone)
            ->assertPropValue('address.address_line1', $address->address_line1)
            ->assertPropValue('address.address_line2', $address->address_line2)
            ->assertPropValue('address.city', $address->city)
            ->assertPropValue('address.country', $address->country)
            ->assertPropValue('address.region', $address->region)
            ->assertPropValue('address.postal_code', $address->postal_code);

            
    }
}
