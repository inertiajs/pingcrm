<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Address;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Profile;
use App\Models\Budget;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Task;
use App\Models\Followup;
use App\Models\Comment;
use App\Models\Restaurant;
use App\Models\Document;
use App\Models\Education;
use App\Models\Issue;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\OfficeRule;
use App\Models\RuleCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        User::factory(5)->create(['account_id' => $account->id]);

        $organizations = Organization::factory(100)
            ->create(['account_id' => $account->id]);



        $experiences = factory(Experience::class, 100)
        ->create(['account_id' => $account->id]);

        $tasks = factory(Task::class, 100)
            ->create(['account_id' => $account->id]);


        $rulecategory = factory(RuleCategory::class, 100)
            ->create(['account_id' => $account->id]);


        $issues = factory(Issue::class, 100)
            ->create(['account_id' => $account->id]);

        $clients = factory(Client::class, 100)
            ->create(['account_id' => $account->id]);

        $projects = factory(Project::class, 100)
            ->create(['account_id' => $account->id]);

        $restaurants = factory(Restaurant::class, 100)
             ->create(['account_id' => $account->id]);

        $education = factory(Education::class, 100)
            ->create(['account_id' => $account->id]);

        $followups = factory(Followup::class, 100)
            ->create(['account_id' => $account->id]);

        $budgets = factory(Budget::class, 100)
            ->create(['account_id' => $account->id]);

        $comments = factory(Comment::class, 100)
            ->create(['account_id' => $account->id]);

        $documents = factory(Document::class, 100)
            ->create(['account_id' => $account->id]);

        $addresses = factory(Address::class, 100)
            ->create(['account_id' => $account->id]);

        $banks = factory(Bank::class, 100)
            ->create(['account_id' => $account->id]);

        $officeRule = factory(OfficeRule::class, 100)
            ->create(['account_id' => $account->id]);

            $issues = factory(Issue::class, 100)
                ->create(['account_id' => $account->id]);

        $clients = factory(Client::class, 100)
            ->create(['account_id' => $account->id]);

        $projects = factory(Project::class, 100)
            ->create(['account_id' => $account->id]);

        $profiles = factory(Profile::class, 100)
            ->create(['account_id' => $account->id]);


        $holidays = factory(Holiday::class, 100)
            ->create(['account_id' => $account->id]);


        $leaves = factory(Leave::class, 100)
            ->create(['account_id' => $account->id]);



        $holidays = factory(Holiday::class, 100)
        ->create(['account_id' => $account->id]);

        factory(Contact::class, 100)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });
    }
}
