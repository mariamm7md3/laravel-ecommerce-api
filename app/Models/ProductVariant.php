<?php

namespace App\Models;

use App\Observers\ProductVariantObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ProductVariantObserver::class])]
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'stock_quantity',
        'product_limit',
        'unit_id',
        'product_id',
        'product_size_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sales (): BelongsToMany
    {
        return $this->belongsToMany(Sale::class , 'product_sale');
    }

    public function cartItems (): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems (): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productUnit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class ,'unit_id');
    }

    public function productSize(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class);
    }

    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {

                $sale = $this->sales->first();

                return $sale
                    ? round($this->price * (1 - $sale->percentage / 100), 2)
                    : $this->price;
            }
        );
    }
}




