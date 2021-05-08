<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Bank;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BanksTest extends TestCase
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

    public function test_can_view_banks()
    {
        $this->user->account->banks()->saveMany(
            factory(Bank::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/banks')
            ->assertStatus(200)
            ->assertPropCount('banks.data', 5)
            ->assertPropValue('banks.data', function ($banks) {
                $this->assertEquals(
                    [
                        'id', 'name', 'phone', 'account_number',
                        'ifsc_code', 'bank_name','email','deleted_at',
                    ],
                    array_keys($banks[0])
                );
            });
    }

    public function test_can_search_for_banks()
    {
        $this->user->account->banks()->saveMany(
            factory(Bank::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/banks?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('banks.data', 1)
            ->assertPropValue('banks.data', function ($banks) {
                $this->assertEquals('Greg Andersson', $banks[0]['name']);
            });
    }

    public function test_cannot_view_deleted_banks()
    {
        $this->user->account->banks()->saveMany(
            factory(Bank::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/banks')
            ->assertStatus(200)
            ->assertPropCount('banks.data', 4);
    }

    public function test_can_filter_to_view_deleted_banks()
    {
        $this->user->account->banks()->saveMany(
            factory(Bank::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/banks?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('banks.data', 5);
    }

    public function test_can_view_single_bank()
    {
        $bank =  $this->user->account->banks()->saveMany(
            factory(Bank::class, 5)->make()
        )->first();

        //$bank = $bank->fresh();

        $this->actingAs($this->user)
            ->get('/banks/' . $bank->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('bank.name', $bank->name)
            ->assertPropValue('bank.phone', $bank->phone)
            ->assertPropValue('bank.account_number', $bank->account_number)
            ->assertPropValue('bank.ifsc_code', $bank->ifsc_code)
            ->assertPropValue('bank.bank_name', $bank->bank_name)
            ->assertPropValue('bank.email', $bank->email);
   
    }
}
