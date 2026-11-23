<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

class Product extends BaseModel
{
    use HasFactory;
    use ImageTrait;
    use Searchable;

    protected $fillable =
        [
            'name',
            'description',
            'photo',
            'price',
            'industry_id',
            'is_active',
        ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
        ];
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class , 'product_categories');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(WishListItem::class);
    }


    public function orderItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            OrderItem::class,
            ProductVariant::class,
            'product_id',
            'product_variant_id',
        );
    }

    public function scopePopular($query)
    {
        return $query->withCount(['orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(order_items.quantity)'))
                    ->whereHas('order', function ($q) {
                        $q->where('orders.created_at', '>=', Carbon::now()->subDays(30));
                    });
            }])
            ->with(['variants' => function ($query) {
                $query->orderBy('price')
                    ->with(['sales' => function ($q) {
                        $q->where('is_active', true)
                            ->where('end_date', '>=', Carbon::now());
                    }]);
            }])
            ->orderByDesc('total_sold');
    }

    public function scopeFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $query->where(
                'name->' . app()->getLocale(),
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('min_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('price', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('price', '<=', $request->max_price);
            });
        }

        if ($request->filled('available')) {

            if ($request->available === 'true') {
                $query->whereHas('variants', function ($q) {
                    $q->where('stock_quantity', '>', 0);
                });
            } else {
                $query->whereHas('variants', function ($q) {
                    $q->where('stock_quantity', 0);
                });
            }
        }

        return $query;
    }

    public function scopeForAdminList($query)
    {
        return $query
            ->with([
                'industry:id,name',
                'categories:id,name',
            ])
            ->withMin('variants as min_price', 'price')
            ->withSum('variants as total_stock', 'stock_quantity');
    }
    public function scopeAdminFilter($query, Request $request)
    {
        return $query

            ->when($request->filled('search'), function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('name->ar', 'like', "%{$request->search}%")
                        ->orWhere('name->en', 'like', "%{$request->search}%");

                });

            })

            ->when($request->filled('industry_id'), function ($query) use ($request) {

                $query->where('industry_id', $request->industry_id);

            })

            ->when($request->filled('category_id'), function ($query) use ($request) {

                $query->whereHas('categories', function ($q) use ($request) {
                    $q->where('categories.id', $request->category_id);
                });

            })

            ->when($request->filled('status'), function ($query) use ($request)
            {

                $query->where('is_active', $request->status);

            });
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->photo);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,

            'name_ar' => $this->name['ar'] ?? '',
            'name_en' => $this->name['en'] ?? '',
            'description_ar' => $this->description['ar'] ?? '',
            'description_en' => $this->description['en'] ?? '',

            'price' => $this->variants->min('price') ?? 0,

            'categories_ar' => $this->categories->pluck('name')
                ->map(fn ($name) => $name['ar'] ?? '')
                ->filter()
                ->values()
                ->toArray(),

            'categories_en' => $this->categories->pluck('name')
                ->map(fn ($name) => $name['en'] ?? '')
                ->filter()
                ->values()
                ->toArray(),

            'industry_ar' => $this->industry?->name['ar'] ?? '',
            'industry_en' => $this->industry?->name['en'] ?? '',

            'is_active' => (bool) $this->is_active,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_active;
    }

    // eager loading to ignore N+1 problem (1000 of queries to get result)
    public function makeAllSearchableUsing($query)
    {
        return $query->with(['variants', 'categories', 'industry']);
    }


}
