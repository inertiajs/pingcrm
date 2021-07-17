<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HolidaysTest extends TestCase
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

    public function test_can_view_holidays()
    {
        $this->user->account->holidays()->saveMany(
            factory(Holiday::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/holidays')
            ->assertStatus(200)
            ->assertPropCount('holidays.data', 5)
            ->assertPropValue('holidays.data', function ($holidays) {
                $this->assertEquals(
                    [
                    'id', 'month', 'weak','day','date',
                     
                    ],
                    array_keys($holidays[0])
                );
            });
    }

    public function test_can_search_for_holidays()
    {
        $this->user->account->holidays()->saveMany(
            factory(Holiday::class, 5)->make()
        )->first()->update([
            'month' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/holidays?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('holidays.data', 1)
            ->assertPropValue('holidays.data', function ($holidays) {
                $this->assertEquals('Greg Andersson', $holidays[0]['month']);
            });
    }

    public function test_cannot_view_deleted_holidays()
    {
        $this->user->account->holidays()->saveMany(
            factory(Holiday::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/holidays')
            ->assertStatus(200)
            ->assertPropCount('holidays.data', 4);
    }

    public function test_can_filter_to_view_deleted_holidays()
    {
        $this->user->account->holidays()->saveMany(
            factory(Holiday::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/holidays?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('holidays.data', 5);
    }
    
    public function test_can_view_single_holiday()
    {
        $holiday =  $this->user->account->holidays()->saveMany(
            factory(Holiday::class, 5)->make()
        )->first();

        //$holiday = $holiday->fresh();

        $this->actingAs($this->user)
            ->get('/holidays/' . $holiday->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('holiday.month', $holiday->month)
            ->assertPropValue('holiday.weak', $holiday->weak)
            ->assertPropValue('holiday.day', $holiday->day)
            ->assertPropValue('holiday.date', $holiday->date)
           
           ;
    }
}
