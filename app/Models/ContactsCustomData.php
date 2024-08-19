<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsCustomData extends Model
{
    protected $table = 'contacts_custom_data';
    protected $fillable = ['value'];
    use HasFactory;
}
