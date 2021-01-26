<?php

namespace App\Models;


class Status extends Model
{
    protected $table = 'status';

    const STATUS_KEY_PENDING = 'pending';
    const STATUS_KEY_REVIEW = 'review';
    const STATUS_KEY_VALID = 'valid';
    const STATUS_KEY_INVALID = 'invalid';
    const STATUS_KEY_EXCLUDED = 'excluded';

    public function documents()
    {
        return $this->hasMany(Document::class, 'status_id', 'id');
    }
}
