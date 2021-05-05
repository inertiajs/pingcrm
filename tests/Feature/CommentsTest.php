<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
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

    public function test_can_view_comments()
    {
        $this->user->account->comments()->saveMany(
            factory(Comment::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/comments')
            ->assertStatus(200)
            ->assertPropCount('comments.data', 5)
            ->assertPropValue('comments.data', function ($comments) {
                $this->assertEquals(
                    [
                    'id', 'description', 'user_id',
                    'task_id', 'assigned_user_id','type', 
                    ],
                    array_keys($comments[0])
                );
            });
    }

    public function test_can_search_for_comments()
    {
        $this->user->account->comments()->saveMany(
            factory(Comment::class, 5)->make()
        )->first()->update([
            'user_id' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/comments?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('comments.data', 1)
            ->assertPropValue('comments.data', function ($comments) {
                $this->assertEquals('Greg Andersson', $comments[0]['user_id']);
            });
    }

    public function test_cannot_view_deleted_comments()
    {
        $this->user->account->comments()->saveMany(
            factory(Comment::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/comments')
            ->assertStatus(200)
            ->assertPropCount('comments.data', 4);
    }

    public function test_can_filter_to_view_deleted_comments()
    {
        $this->user->account->comments()->saveMany(
            factory(Comment::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/comments?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('comments.data', 5);
    }
    
    public function test_can_view_single_client()
    {
        $comment =  $this->user->account->clients()->saveMany(
            factory(Comment::class, 5)->make()
        )->first();

        //$comment = $comment->fresh();

        $this->actingAs($this->user)
            ->get('/comments/' . $comment->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('comment.user_id', $comment->user_id)
            ->assertPropValue('comment.task_id', $comment->task_id)
            ->assertPropValue('comment.assigned_user_id', $comment->assigned_user_id)
            ->assertPropValue('comment.type', $comment->type);
            
    }
}