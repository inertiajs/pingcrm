<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssuesTest extends TestCase
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

    public function test_can_view_issues()
    {
        $this->user->account->issues()->saveMany(
            factory(Issue::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/issues')
            ->assertStatus(200)
            ->assertPropCount('issues.data', 5)
            ->assertPropValue('issues.data', function ($issues) {
                $this->assertEquals(
                    [
                        'id', 'issue', 'description', 'status', 'priority',
                        'fix', 'assign', 'due_date', 'completed_date', 'deleted_at',
                    ],
                    array_keys($issues[0])
                );
            });
    }

    public function test_can_search_for_issues()
    {
        $this->user->account->issues()->saveMany(
            factory(Issue::class, 5)->make()
        )->first()->update([
            'issue' => 'Greg Andersson',
        ]);



        $this->actingAs($this->user)
            ->get('/issues?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('issues.data', 1)
            ->assertPropValue('issues.data', function ($issues) {
                $this->assertEquals('Greg Andersson', $issues[0]['issue']);
            });
    }

    public function test_cannot_view_deleted_issues()
    {
        $this->user->account->issues()->saveMany(
            factory(Issue::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/issues')
            ->assertStatus(200)
            ->assertPropCount('issues.data', 4);
    }

    public function test_can_filter_to_view_deleted_issues()
    {
        $this->user->account->issues()->saveMany(
            factory(Issue::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/issues?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('issues.data', 5);
    }

    public function test_can_view_single_issue()
    {
        $issue =  $this->user->account->issues()->saveMany(
            factory(Issue::class, 5)->make()
        )->first();

        $issue = $issue->fresh();

        $this->actingAs($this->user)
            ->get('/issues/' . $issue->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('issue.issue', $issue->issue)
            ->assertPropValue('issue.description', $issue->description)
            ->assertPropValue('issue.status', $issue->status)
            ->assertPropValue('issue.priority', $issue->priority)
            ->assertPropValue('issue.fix', $issue->fix)
            ->assertPropValue('issue.assign', $issue->assign)
            ->assertPropValue('issue.due_date', $issue->due_date)
            ->assertPropValue('issue.completed_date', $issue->completed_date);
    }
}
