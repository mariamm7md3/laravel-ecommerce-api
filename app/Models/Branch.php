<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'shipping_cost',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'address' => 'array',
        ];
    }
    public function deliveryTimes (): HasMany
    {
        return $this->hasMany(DeliveryTime::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
