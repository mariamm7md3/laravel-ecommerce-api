<?php

namespace App\Models;

use App\Observers\IndustryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([IndustryObserver::class])]
class Industry extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
        ];
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
