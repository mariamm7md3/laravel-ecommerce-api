<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sale extends BaseModel
{
    use HasFactory;
    protected $fillable =[
        'percentage',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    public function variants (): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class , 'product_sale');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
          get:function(){
              $today = now()->startOfDay();

              if( !$this->is_active)
              {
                  return 'inactive';
              }
              if($this->end_date->lt($today))
              {
                  return 'expired';
              }
              if($this->start_date->gt($today))
              {
                  return 'upcoming';
              }
              return 'active';

            }
        );
    }

    public function scopeActive($query)
    {
        $today = now()->startOfDay();
        return $query->where('is_active',true)
            ->where('start_date','<=',$today)
            ->where('end_date','>=',$today);
    }

    public function scopeUpcoming($query)
    {
        $today = now()->startOfDay();
        return $query->where('is_active',true)
            ->where('start_date','>',$today);
    }

    public function scopeExpired($query)
    {
        $today = now()->startOfDay();
        return $query->where('is_active',true)
            ->where('end_date','<',$today);
    }
}
