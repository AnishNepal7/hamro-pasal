<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'description',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function record($productId, $type, $quantity, $description = null)
    {
        $movement = self::create([
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity,
            'description' => $description,
            'created_by' => auth()->id(),
        ]);

        // Update product quantity
        $product = Product::find($productId);
        if ($product) {
            if ($type === 'IN') {
                $product->increment('quantity', $quantity);
            } elseif ($type === 'OUT') {
                $product->decrement('quantity', $quantity);
            }
        }

        return $movement;
    }
}
