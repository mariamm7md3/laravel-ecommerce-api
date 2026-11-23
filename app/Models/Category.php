<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

#[ObservedBy([CategoryObserver::class])]
class Category extends BaseModel
{
    use HasFactory , ImageTrait;
    protected $fillable = [
        'name',
        'icon',
        'description',
        'is_active',
    ];
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'name' => 'array',
            'description'=>'array',
        ];
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class , 'product_categories');
    }

    public function scopeAdminFilter ($query, Request $request)
    {
        return $query

            ->when($request->filled('search'), function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('name->ar', 'like', "%{$request->search}%")
                        ->orWhere('name->en', 'like', "%{$request->search}%");

                });

            })

            ->when($request->filled('is_active'), function ($query) use ($request)
            {

                $query->where('is_active', $request->is_active);

            });
    }
    public function getIconUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->icon);
    }
}
