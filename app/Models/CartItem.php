<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_items';

    protected $fillable = [
        'quantity',
        'preparation_note',
        'product_variant_id',
    ];
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class , 'product_variant_id');
    }
}
