<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
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

    public function test_can_view_profiles()
    {
        $this->user->account->profiles()->saveMany(
            factory(Profile::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/profiles')
            ->assertStatus(200)
            ->assertPropCount('profiles.data', 5)
            ->assertPropValue('profiles.data', function ($profiles) {
                $this->assertEquals(
                    [
                        'id', 'name', 'phone', 'city',
                        'job', 'nationality', 'deleted_at',
                    ],
                    array_keys($profiles[0])
                );
            });
    }

    public function test_can_search_for_profiles()
    {
        $this->user->account->profiles()->saveMany(
            factory(Profile::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/profiles?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('profiles.data', 1)
            ->assertPropValue('profiles.data', function ($profiles) {
                $this->assertEquals('Greg Andersson', $profiles[0]['name']);
            });
    }

    public function test_cannot_view_deleted_profiles()
    {
        $this->user->account->profiles()->saveMany(
            factory(Profile::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/profiles')
            ->assertStatus(200)
            ->assertPropCount('profiles.data', 4);
    }

    public function test_can_filter_to_view_deleted_profiles()
    {
        $this->user->account->profiles()->saveMany(
            factory(Profile::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/profiles?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('profiles.data', 5);
    }

    public function test_can_view_single_profile()
    {
        $profile =  $this->user->account->profiles()->saveMany(
            factory(Profile::class, 5)->make()
        )->first();

        //$profile = $profile->fresh();

        $this->actingAs($this->user)
            ->get('/profiles/' . $profile->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('profile.name', $profile->name)
            ->assertPropValue('profile.phone', $profile->phone)
            ->assertPropValue('profile.city', $profile->city)
            ->assertPropValue('profile.job', $profile->job)
            ->assertPropValue('profile.nationality', $profile->nationality);
    }
}
