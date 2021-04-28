<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExperiencesTest extends TestCase
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

    public function test_can_view_experiences()
    {
        $this->user->account->experiences()->saveMany(
            factory(Experience::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/experiences')
            ->assertStatus(200)
            ->assertPropCount('experiences.data', 5)
            ->assertPropValue('experiences.data', function ($experiences) {
                $this->assertEquals(
                    [
                        'id', 'name', 'company', 'start_date',
                        'end_date', 'total_experience', 'deleted_at',
                    ],
                    array_keys($experiences[0])
                );
            });
    }

    public function test_can_search_for_experiences()
    {
        $this->user->account->experiences()->saveMany(
            factory(Experience::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/experiences?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('experiences.data', 1)
            ->assertPropValue('experiences.data', function ($experiences) {
                $this->assertEquals('Greg Andersson', $experiences[0]['name']);
            });
    }

    public function test_cannot_view_deleted_experiences()
    {
        $this->user->account->experiences()->saveMany(
            factory(Experience::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/experiences')
            ->assertStatus(200)
            ->assertPropCount('experiences.data', 4);
    }

    public function test_can_filter_to_view_deleted_experiences()
    {
        $this->user->account->experiences()->saveMany(
            factory(Experience::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/experiences?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('experiences.data', 5);
    }

    public function test_can_view_single_experience()
    {
        $experience =  $this->user->account->experiences()->saveMany(
            factory(Experience::class, 5)->make()
        )->first();

        //$experience = $experience->fresh();

        $this->actingAs($this->user)
            ->get('/experiences/' . $experience->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('experience.name', $experience->name)
            ->assertPropValue('experience.company', $experience->company)
            ->assertPropValue('experience.start_date', $experience->start_date)
            ->assertPropValue('experience.end_date', $experience->end_date)
            ->assertPropValue('experience.total_experience', $experience->total_experience);
    }
}
