<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WishListItem extends Model
{
    use HasFactory;
    protected $table = 'wishlist_items';

    protected $fillable = [
        'product_id',
        'wishlist_id',
    ];
    public function wishList(): BelongsTo
    {
        return $this->belongsTo(WishList::class , 'wishlist_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


}
