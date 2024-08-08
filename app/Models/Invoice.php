<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = ['number', 'amount', 'organization_id', 'contact_id'];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->with('items')->firstOrFail();
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
