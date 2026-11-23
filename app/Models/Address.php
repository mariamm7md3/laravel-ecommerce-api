<?php

namespace App\Models;

use App\Enums\BuildingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nickname',
        'phone',
        'governate',
        'type',
        'building',
        'floor',
        'apartment',
        'details',
        'neighborhood',
        'is_main',
        'is_active',
    ];
    protected function casts(): array
    {
        return [
            'type'=> BuildingType::class,
            'is_active'=>'boolean',
            'is_main'=>'boolean',
        ];
    }

    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders (): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
