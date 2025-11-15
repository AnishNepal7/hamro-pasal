<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'quantity',
        'purchase_price',
        'selling_price',
        'user_id',
        'is_global'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
     public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeVisibleTo($query, $user)
    {
        return $query->where('is_global', true)
            ->orWhere('user_id', $user->id);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }


    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
