<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentsTest extends TestCase
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

    public function test_can_view_documents()
    {
        $this->user->account->documents()->saveMany(
            factory(Document::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/documents')
            ->assertStatus(200)
            ->assertPropCount('documents.data', 5)
            ->assertPropValue('documents.data', function ($documents) {
                $this->assertEquals(
                    ['id', 'title', 'customer_name',
                    'document_label','document_type', 'digit', 'length'],
                    array_keys($documents[0])
                );
            });
    }

    public function test_can_search_for_documents()
    {
        $this->user->account->documents()->saveMany(
            factory(Document::class, 5)->make()
        )->first()->update([
            'customer_name' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/documents?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('documents.data', 1)
            ->assertPropValue('documents.data', function ($documents) {
                $this->assertEquals('Greg Andersson', $documents[0]['customer_name']);
            });
    }

    public function test_cannot_view_deleted_documents()
    {
        $this->user->account->documents()->saveMany(
            factory(Document::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/documents')
            ->assertStatus(200)
            ->assertPropCount('documents.data', 4);
    }

    public function test_can_filter_to_view_deleted_documents()
    {
        $this->user->account->documents()->saveMany(
            factory(Document::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/documents?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('documents.data', 5);
    }

public function test_can_view_single_client()
{
    $task =  $this->user->account->clients()->saveMany(
        factory(Client::class, 5)->make()
    )->first();

    //$task = $task->fresh();

    $this->actingAs($this->user)
        ->get('/tasks/' . $task->id . "/edit")
        ->assertStatus(200)
        ->assertPropValue('task.name', $task->id)
        ->assertPropValue('task.phone', $task->title)
       
        ->assertPropValue('task.status', $task->customer_name);
        ->assertPropValue('task.status', $task->document_label);
        ->assertPropValue('task.status', $task->document_type);
        ->assertPropValue('task.status', $task->digit);
        ->assertPropValue('task.priority',$task->length);
}

}