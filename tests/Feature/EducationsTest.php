<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Education;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationsTest extends TestCase
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

    public function test_can_view_educations()
    {
        $this->user->account->educations()->saveMany(
            factory(Education::class, 5)->make()
        );

        $this->actingAs($this->user)
            ->get('/educations')
            ->assertStatus(200)
            ->assertPropCount('educations.data', 5)
            ->assertPropValue('educations.data', function ($educations) {
                $this->assertEquals(
                    [
                        'id', 'title', 'name',
                        'email', 'phone', 'school', 'college','higher_education','percentage',
                    ],
                    array_keys($educations[0])
                );
            });
    }

    public function test_can_search_for_educations()
    {
        $this->user->account->educations()->saveMany(
            factory(Education::class, 5)->make()
        )->first()->update([
            'name' => 'Greg Andersson'
        ]);

        $this->actingAs($this->user)
            ->get('/educations?search=Greg')
            ->assertStatus(200)
            ->assertPropValue('filters.search', 'Greg')
            ->assertPropCount('educations.data', 1)
            ->assertPropValue('educations.data', function ($educations) {
                $this->assertEquals('Greg Andersson', $educations[0]['name']);
            });
    }

    public function test_cannot_view_deleted_educations()
    {
        $this->user->account->educations()->saveMany(
            factory(Education::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/educations')
            ->assertStatus(200)
            ->assertPropCount('educations.data', 4);
    }

    public function test_can_filter_to_view_deleted_educations()
    {
        $this->user->account->educations()->saveMany(
            factory(Education::class, 5)->make()
        )->first()->delete();

        $this->actingAs($this->user)
            ->get('/educations?trashed=with')
            ->assertStatus(200)
            ->assertPropValue('filters.trashed', 'with')
            ->assertPropCount('educations.data', 5);
    }
    
    public function test_can_view_single_client()
    {
        $education =  $this->user->account->clients()->saveMany(
            factory(Education::class, 5)->make()
        )->first();

        //$education = $education->fresh();

        $this->actingAs($this->user)
            ->get('/educations/' . $education->id . "/edit")
            ->assertStatus(200)
            ->assertPropValue('education.name', $education->name)
            ->assertPropValue('education.email', $education->email)
            ->assertPropValue('education.phone', $education->phone)
            ->assertPropValue('education.school', $education->school)
            ->assertPropValue('education.college', $education->college)
            ->assertPropValue('education.higher_education', $education->higher_education)
            ->assertPropValue('education.percentage', $education->percentage);
            
    }
}
