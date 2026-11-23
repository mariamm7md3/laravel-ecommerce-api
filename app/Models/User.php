<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Gender;
use App\Traits\ImageTrait;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable , ImageTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'photo',
        'gender',
        'password',
        'date_of_birth',
        'is_main',
        'user_id',
        'is_active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            'is_active' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }


    function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function cart():HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function wishList():HasOne
    {
        return $this->hasOne(WishList::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function discountCodes(): BelongsToMany
    {
        return $this->belongsToMany(DiscountCode::class, 'user_discount_usage');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(UserMessage::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getImageUrl($this->photo);
    }

    public function fcmTokens(): HasMany
    {
        return $this->hasMany(UserFcmToken::class);
    }
    public function scopeAdminFilter($query)
    {
        return $query
            ->when(request('search'), function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . request('search') . '%')
                        ->orWhere('last_name', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%');
                });
            })

            ->when(request('gender'), function ($query) {
                return $query->where('gender', request('gender'));
            })

            ->when(request('is_active'), function ($query) {
                return $query->where('is_active', request('is_active'));
            });
    }

}
