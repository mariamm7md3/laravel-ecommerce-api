<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'user_id',
        'branch_id',
        'address_id',
        'delivery_time_id',
        'sub_total',
        'shipping',
        'discount',
        'total',
        'additional_info',
        'status',
    ];

    protected $casts = [
        'status' => \App\Enums\OrderStatus::class,
        'date'   => 'datetime',
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address():BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function rate():HasOne
    {
        return $this->hasOne(Rate::class);
    }

    public function deliveryTime(): BelongsTo
    {
        return $this->belongsTo(DeliveryTime::class);
    }

    public function discountCodes(): BelongsToMany
    {
        return $this->belongsToMany(DiscountCode::class,'order_discounts');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function notifications (): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function scopeAdminFilter($query, Request $request)
    {
        return $query
            ->when($request->filled('user_name'), function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->user_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->user_name . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('date', '<=', $request->end_date);
            })
            ->when($request->boolean('show_deleted'), function ($query) {
            $query->onlyTrashed();
            });
    }
}
