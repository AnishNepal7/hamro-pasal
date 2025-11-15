<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // protected $fillable = ['name'];
      protected $fillable = ['name', 'user_id'];

    // Scope to filter categories visible to a user
    public function scopeVisibleTo($query, $user)
    {
        if ($user->isAdmin()) {
            // Admin can see all categories
            return $query;
        }

        // Normal users can see either global categories or their own
        return $query->Where('user_id', $user->id);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}