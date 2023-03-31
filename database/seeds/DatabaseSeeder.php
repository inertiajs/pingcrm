<?php

use App\Models\Account;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Requirement;
use App\Models\Status;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Equipos y Tractores del Bajio']);
        Status::create(['text' => 'Por Cargar', 'key' => Status::STATUS_KEY_PENDING]);
        Status::create(['text' => 'En Revision', 'key' => Status::STATUS_KEY_REVIEW]);
        Status::create(['text' => 'Validos', 'key' => Status::STATUS_KEY_VALID]);
        Status::create(['text' => 'Invalidos', 'key' => Status::STATUS_KEY_INVALID]);
        Status::create(['text' => 'Excluidos', 'key' => Status::STATUS_KEY_EXCLUDED]);

        $category = Category::create(['name' => 'Retroexcabadoras']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'Admin',
            'last_name' => 'Rentas',
            'email' => 'admin@rentas.com',
            'owner' => true,
        ]);

        factory(User::class, 2)->create(['account_id' => $account->id]);

        $organizations = factory(Organization::class, 5)
            ->create(['account_id' => $account->id]);

        factory(Contact::class, 5)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });

        factory(Requirement::class, 5)->create();
        factory(Template::class, 1)->create();
        // factory(Expedient::class, 100)->create();
    }
}
