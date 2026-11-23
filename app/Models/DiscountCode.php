<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiscountCode extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'code',
        'start_date',
        'end_date',
        'percentage',
        'max_discount_limit',
        'usage_limit',
        'is_once',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'is_once'    => 'boolean',
            'is_active'  => 'boolean',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class ,'user_discount_usage');
    }
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class ,'order_discounts');
    }
}
