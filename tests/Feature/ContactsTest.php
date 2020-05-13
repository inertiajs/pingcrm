<?php

namespace Tests\Feature;

use App\User;
use App\Account;
use App\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
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

    public function test_can_view_contacts()
    {
        $this->user->account->contacts()->saveMany(
            factory(Contact::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/contacts')
            ->assertStatus(200)
            ->assertPropCount('contacts.data', 5)
            ->assertPropValue('contacts.data', function ($contacts) {
                $this->assertEquals(
                    ['id', 'name', 'phone', 'city', 'deleted_at', 'organization'],
                    array_keys($contacts[0])
                );
            })
            ->assertPropsFragment($this->user->only('id', 'first_name', 'last_name', 'email'))
            ->assertPropsFragment($this->user->account->only('id', 'name'))
            ->assertPropsFragment(Contact::first()->only('id', 'name', 'phone', 'city'));
    }

    public function test_can_search_for_contacts()
    {
        $this->user->account->contacts()->saveMany(
            factory(contact::class, 5)->make()
        )->first()->update([
            'first_name' => 'Greg',
            'last_name' => 'Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/contacts?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('contacts.data', 1)
            ->assertPropValue('contacts.data', function ($contacts) {
                $this->assertEquals('Greg Andersson', $contacts[0]['name']);
            })
            ->assertPropsFragment(Contact::first()->only('id', 'name'));
    }

    public function test_cannot_view_deleted_contacts()
    {
        $this->user->account->contacts()->saveMany(
            factory(contact::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/contacts')
            ->assertStatus(200)
            ->assertPropCount('contacts.data', 4);
    }

    public function test_can_filter_to_view_deleted_contacts()
    {
        $this->user->account->contacts()->saveMany(
            factory(contact::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/contacts?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('contacts.data', 5);
    }
}
