<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Budget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetsTest extends TestCase
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

    public function test_can_view_budgets()
    {
        $this->user->account->budgets()->saveMany(
            factory(Budget::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/budgets')
            ->assertStatus(200)
            ->assertPropCount('budgets.data', 5)
            ->assertPropValue('budgets.data', function ($budgets) {
                $this->assertEquals(
                    [
                        'id', 'project_name', 'resources', 'cost',
                        'profit', 'loss', 'deleted_at',
                    ],
                    array_keys($budgets[0])
                );
            });
    }

    public function test_can_search_for_budgets()
    {
        $this->user->account->budgets()->saveMany(
            factory(Budget::class, 5)->make()
        )->first()->update([
            'project_name' => 'Greg Andersson',
        ]);

        $this->actingAs($this->user)
            ->get('/budgets?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('budgets.data', 1)
            ->assertPropValue('budgets.data', function ($budgets) {
                $this->assertEquals('Greg Andersson', $budgets[0]['project_name']);
            });
    }

    public function test_cannot_view_deleted_budgets()
    {
        $this->user->account->budgets()->saveMany(
            factory(Budget::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/budgets')
            ->assertStatus(200)
            ->assertPropCount('budgets.data', 4);
    }

    public function test_can_filter_to_view_deleted_budgets()
    {
        $this->user->account->budgets()->saveMany(
            factory(Budget::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/budgets?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('budgets.data', 5);
    }

    public function test_can_view_single_budget()
    {
        $budget =  $this->user->account->budgets()->saveMany(
            factory(Budget::class, 5)->make()
        )->first();

        //$budget = $budget->fresh();

        $this->actingAs($this->user)
            ->get('/budgets/' . $budget->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('budget.project_name', $budget->project_name)
            ->assertPropValue('budget.resources', $budget->resources)
            ->assertPropValue('budget.cost', $budget->cost)
            ->assertPropValue('budget.profit', $budget->profit)
            ->assertPropValue('budget.loss', $budget->loss);
    }
}
