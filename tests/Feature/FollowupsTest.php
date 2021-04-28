<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Followup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowupsTest extends TestCase
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

    public function test_can_view_followups()
    {
        $this->user->account->followups()->saveMany(
            factory(Followup::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/followups')
            ->assertStatus(200)
            ->assertPropCount('followups.data', 5)
            ->assertPropValue('followups.data', function ($followups) {
                $this->assertEquals(
                    [
                        'id', 'title', 'description', 'customer_name',
                        'team_id','email', 'priority', 'status', 'phone','agreement', 'maximum_time','meeting_schedule', 
                    ],
                    array_keys($followups[0])
                );
            });
    }

    public function test_can_search_for_followups()
    {
        $this->user->account->followups()->saveMany(
            factory(Followup::class, 5)->make()
        )->first()->update([
            'customer_name' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/followups?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('followups.data', 1)
            ->assertPropValue('followups.data', function ($followups) {
                $this->assertEquals('Greg Andersson', $followups[0]['customer_name']);
            });
    }

    public function test_cannot_view_deleted_followups()
    {
        $this->user->account->followups()->saveMany(
            factory(Followup::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/followups')
            ->assertStatus(200)
            ->assertPropCount('followups.data', 4);
    }

    public function test_can_filter_to_view_deleted_followups()
    {
        $this->user->account->followups()->saveMany(
            factory(Followup::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/followups?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('followups.data', 5);
    }
    
    public function test_can_view_single_client()
    {
        $followup =  $this->user->account->clients()->saveMany(
            factory(Followup::class, 5)->make()
        )->first();

        //$followup = $followup->fresh();

        $this->actingAs($this->user)
            ->get('/followups/' . $followup->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('followup.customer_name', $followup->customer_name)
            ->assertPropValue('followup.team_id', $followup->team_id)
            ->assertPropValue('followup.email', $followup->email)
            ->assertPropValue('followup.priority',$followup->priority)
            ->assertPropValue('followup.status', $followup->status)
            ->assertPropValue('followup.phone', $followup->phone)
            ->assertPropValue('followup.agreement', $followup->agreement)
            ->assertPropValue('followup.maximum_time', $followup->maximum_time)
            ->assertPropValue('followup.meeting_schedule', $followup->meeting_schedule);           
    }
}
