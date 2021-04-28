<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientsTest extends TestCase
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

    public function test_can_view_clients()
    {
        $this->user->account->clients()->saveMany(
            factory(Client::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/clients')
            ->assertStatus(200)
            ->assertPropCount('clients.data', 5)
            ->assertPropValue('clients.data', function ($clients) {
                $this->assertEquals(
                    [
                        'id', 'name', 'phone', 'priority',
                        'status', 'deleted_at',
                    ],
                    array_keys($clients[0])
                );
            });
    }

    public function test_can_search_for_clients()
    {
        $this->user->account->clients()->saveMany(
            factory(Client::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/clients?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('clients.data', 1)
            ->assertPropValue('clients.data', function ($clients) {
                $this->assertEquals('Greg Andersson', $clients[0]['name']);
            });
    }

    public function test_cannot_view_deleted_clients()
    {
        $this->user->account->clients()->saveMany(
            factory(Client::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/clients')
            ->assertStatus(200)
            ->assertPropCount('clients.data', 4);
    }

    public function test_can_filter_to_view_deleted_clients()
    {
        $this->user->account->clients()->saveMany(
            factory(Client::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/clients?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('clients.data', 5);
    }

    public function test_can_view_single_client()
    {
        $client =  $this->user->account->clients()->saveMany(
            factory(Client::class, 5)->make()
        )->first();

        //$client = $client->fresh();

        $this->actingAs($this->user)
            ->get('/clients/' . $client->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('client.name', $client->name)
            ->assertPropValue('client.phone', $client->phone)
            ->assertPropValue('client.priority', $client->priority)
            ->assertPropValue('client.status', $client->status);
    }
}
