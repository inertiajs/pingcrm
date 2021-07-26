<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeavesTest extends TestCase
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

    public function test_can_view_leaves()
    {
        $this->user->account->leaves()->saveMany(
            factory(Leave::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/leaves')
            ->assertStatus(200)
            ->assertPropCount('leaves.data', 5)
            ->assertPropValue('leaves.data', function ($leaves) {
                $this->assertEquals(
                    [
                        'id', 'name', 'contact_no', 'day',
                        'date', 'reason_of_leave',
                    ],
                    array_keys($leaves[0])
                );
            });
    }

    public function test_can_search_for_leaves()
    {
        $this->user->account->leaves()->saveMany(
            factory(Leave::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/leaves?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('leaves.data', 1)
            ->assertPropValue('leaves.data', function ($leaves) {
                $this->assertEquals('Greg Andersson', $leaves[0]['name']);
            });
    }

    public function test_cannot_view_deleted_leaves()
    {
        $this->user->account->leaves()->saveMany(
            factory(Leave::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/leaves')
            ->assertStatus(200)
            ->assertPropCount('leaves.data', 4);
    }

    public function test_can_filter_to_view_deleted_leaves()
    {
        $this->user->account->leaves()->saveMany(
            factory(Leave::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/leaves?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('leaves.data', 5);
    }

    public function test_can_view_single_leave()
    {
        $leave =  $this->user->account->leaves()->saveMany(
            factory(Leave::class, 5)->make()
        )->first();

        //$leave = $leave->fresh();

        $this->actingAs($this->user)
            ->get('/leaves/' . $leave->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('leave.name', $leave->name)
            ->assertPropValue('leave.contact_no', $leave->contact_no)
            ->assertPropValue('leave.day', $leave->day)
            ->assertPropValue('leave.date', $leave->date)
            ->assertPropValue('leave.reason_of_leave', $leave->reason_of_leave);
    }
}
