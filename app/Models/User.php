<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Champs autorisés pour l'assignation de masse.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'login_attempts',
        'blocked_until',
    ];

    /**
     * Champs cachés lors de la sérialisation.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * Conversion automatique des types.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',

            'password' => 'hashed',

            'last_login_at' => 'datetime',

            'blocked_until' => 'datetime',

            'two_factor_expires_at' => 'datetime',

            'is_blocked' => 'boolean',

            'login_attempts' => 'integer',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | EMPRUNTS
    |--------------------------------------------------------------------------
    */

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }


    /*
    |--------------------------------------------------------------------------
    | FAVORIS
    |--------------------------------------------------------------------------
    */

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }


    /*
    |--------------------------------------------------------------------------
    | RÉSERVATIONS
    |--------------------------------------------------------------------------
    */

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    /*
    |--------------------------------------------------------------------------
    | ADRESSES IP CONNUES
    |--------------------------------------------------------------------------
    */

    public function ips()
    {
        return $this->hasMany(UserIp::class);
    }


    /*
    |--------------------------------------------------------------------------
    | JOURNAL DE SÉCURITÉ
    |--------------------------------------------------------------------------
    */

    public function securityLogs()
    {
        return $this->hasMany(SecurityLog::class);
    }


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATEUR
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}