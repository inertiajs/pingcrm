<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CustomColumnsUpdated;
use App\Models\ContactCustomColumns;

class UpdateAdditionalData
{
    public function handle(CustomColumnsUpdated $event)
    {
        $contact = $event->contact;
        $columns = $event->columns;
        $additionalData = json_decode($contact->additional_data, true) ?: [];

        foreach ($columns as $column) {
            if (isset($column['value']) && $column['value'] !== null) {
                $columnName = ContactCustomColumns::where('id', $column['id'])->value('name');
                $additionalData[$columnName] = $column['value'];
            }
        }

        $contact->update([
            'additional_data' => json_encode($additionalData),
        ]);
    }
}
