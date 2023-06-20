<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    use HasRoles;

    // create event with booted method to create assoiction with empty data
    protected static function booted()
    {
        static::created(function ($user) {
            $user->association()->create();
            ReunionType::create(['name' => 'Normal', 'user_id' => $user->id]);
            ReunionType::create(['name' => 'Urgent', 'user_id' => $user->id]);
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adherants(): HasMany
    {
        return $this->hasMany(Adherant::class);
    }

    public function groupes(): HasMany
    {
        return $this->hasMany(Groupe::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stockTypes(): HasMany
    {
        return $this->hasMany(StockType::class);
    }

    public function revenueTypes(): HasMany
    {
        return $this->hasMany(RevenueType::class);
    }

    public function depenseTypes(): HasMany
    {
        return $this->hasMany(DepenseType::class);
    }

    public function cotisationTypes(): HasMany
    {
        return $this->hasMany(CotisationType::class);
    }

    public function evenementTypes(): HasMany
    {
        return $this->hasMany(EvenementType::class);
    }

    public function evenements(): HasMany
    {
        return $this->hasMany(Evenement::class);
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }

    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }

    public function status(): HasMany
    {
        return $this->hasMany(Statut::class);
    }

    public function association(): HasOne
    {
        return $this->hasOne(Association::class);
    }

    public function reunions(): HasMany
    {
        return $this->hasMany(Reunion::class);
    }

    public function rapports(): HasMany
    {
        return $this->hasMany(Rapport::class);
    }

    public function reunionTypes(): HasMany
    {
        return $this->hasMany(ReunionType::class);
    }
}
