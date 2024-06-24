<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Observers\UserObserver;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;

// #[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active'
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
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {

        if (Auth::check()) {
            if(!$this->active){
                Auth::logout();
                redirect('/');
            }
        }

        if(!$this->active){
            return false;
        }

        if ($panel->getId() === 'admin') {
            return $this->hasRole('Admin') && $this->active;
        }

        if ($panel->getId() === 'company') {
            return $this->hasRole(env('APP_ROL_TO_SUSCRIPTOR', 'Gerente')) && $this->companies->count() && $this->companies->first()->active;

        }

        return false;
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
    public function roles_gerente(): HasMany
    {
        return $this->hasMany(Role::class)
            ->whereNotIn('id', [1]);
    }

    public function roles_admin(): HasMany
    {
        return $this->hasMany(Role::class)
            ->whereIn('id', [1, 2]);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function companies_updated(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
