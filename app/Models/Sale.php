<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'discount',
        'tax',
        'payment_method',
        'sale_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Accessor for final total after discount and tax
    public function getFinalAmountAttribute()
    {
        return ($this->total_amount - $this->discount) + $this->tax;
    }
     // Relationship with sale items
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
