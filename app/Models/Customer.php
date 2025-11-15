<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
    ];

    // Relation with sales (optional if you’ll track purchase history)
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
