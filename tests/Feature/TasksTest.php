<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
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

    public function test_can_view_tasks()
    {
        $this->user->account->tasks()->saveMany(
            factory(Task::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/tasks')
            ->assertStatus(200)
            ->assertPropCount('tasks.data', 5)
            ->assertPropValue('tasks.data', function ($tasks) {
                $this->assertEquals(
                    [
                    'id', 'title', 'description','user_id','task_id', 'team_id','project_id',
                    'priority', 'status', 'creator','due_date', 'completed_date', 
                    ],
                    array_keys($tasks[0])
                );
            });
    }

    public function test_can_search_for_tasks()
    {
        $this->user->account->tasks()->saveMany(
            factory(Task::class, 5)->make()
        )->first()->update([
            'title' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/tasks?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('tasks.data', 1)
            ->assertPropValue('tasks.data', function ($tasks) {
                $this->assertEquals('Greg Andersson', $tasks[0]['title']);
            });
    }

    public function test_cannot_view_deleted_tasks()
    {
        $this->user->account->tasks()->saveMany(
            factory(Task::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/tasks')
            ->assertStatus(200)
            ->assertPropCount('tasks.data', 4);
    }

    public function test_can_filter_to_view_deleted_tasks()
    {
        $this->user->account->tasks()->saveMany(
            factory(Task::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/tasks?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('tasks.data', 5);
    }
    
    public function test_can_view_single_task()
    {
        $task =  $this->user->account->tasks()->saveMany(
            factory(Task::class, 5)->make()
        )->first();

        //$task = $task->fresh();

        $this->actingAs($this->user)
            ->get('/tasks/' . $task->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('task.title', $task->title)
            ->assertPropValue('task.user_id', $task->user_id)
            ->assertPropValue('task.task_id', $task->task_id)
            ->assertPropValue('task.team_id', $task->team_id)
            ->assertPropValue('task.project_id', $task->project_id)
            ->assertPropValue('task.priority',$task->priority)
            ->assertPropValue('task.status', $task->status)
            ->assertPropValue('task.creator', $task->creator)
            ->assertPropValue('task.due_date', $task->due_date)
            ->assertPropValue('task.completed_date', $task->completed_date);
           ;
    }
}
