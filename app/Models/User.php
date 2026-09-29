<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'city',
        'state',
        'country',
        'role',
        'permissions',
        'pin_code',
        'doctor_strime',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'permissions' => 'array',
        ];
    }

    /**
     * The logged-in admin-side user (super_admin, doctor or staff), if any.
     */
    public static function currentAdmin(): ?self
    {
        return Auth::guard('super_admin')->user()
            ?? Auth::guard('doctor')->user()
            ?? Auth::guard('staff')->user();
    }

    public function hasPermission(string $key): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        return in_array($key, $this->permissions ?? [], true);
    }

    /**
     * Route name of the first tab this user may open (used after login).
     */
    public function firstPermittedRoute(): string
    {
        foreach (config('permissions') as $key => $tab) {
            if ($this->hasPermission($key)) {
                return $tab['route'];
            }
        }

        return 'admin.settings';
    }
}
