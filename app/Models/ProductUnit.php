<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
    ];
    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}
