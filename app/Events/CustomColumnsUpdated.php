<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class CustomColumnsUpdated
{
    use SerializesModels;

    public $contact;
    public $columns;

    public function __construct(Contact $contact, array $columns)
    {
        $this->contact = $contact;
        $this->columns = $columns;
    }
}
