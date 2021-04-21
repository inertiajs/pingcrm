<?php

use App\Models\Account;
use App\Models\Address;
use App\Models\Bank; 
use App\Models\Client;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Task;
use App\Models\Restaurant;
use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        factory(User::class, 5)->create(['account_id' => $account->id]);

        $organizations = factory(Organization::class, 100)
            ->create(['account_id' => $account->id]);

        $tasks = factory(Task::class, 100)
            ->create(['account_id' => $account->id]);



        // $restaurants = factory(Restaurant::class, 100)
        //     ->create(['account_id' => $account->id]);

         $education = factory(Education::class, 100)
               ->create(['account_id' => $account->id]);

            $addresses = factory(Address::class, 100)
            ->create(['account_id' => $account->id]);

            $banks = factory(Bank::class, 100)


        $clients = factory(Client::class, 100)
            ->create(['account_id' => $account->id]);

        factory(Contact::class, 100)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });
    }
}
