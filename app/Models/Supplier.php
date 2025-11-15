<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'contact', 'email', 'address','user_id'];

      public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}