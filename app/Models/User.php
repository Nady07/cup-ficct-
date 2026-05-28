<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'email',
        'password',
        'role', // ← CAMPO NUEVO REQUERIDO
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
        ];
    }

    // =========================================================================
    // RELACIONES
    // =========================================================================

    /**
     * Relación con Estudiante (si el usuario es un estudiante).
     */
    public function estudiante(): HasOne
    {
        return $this->hasOne(Estudiante::class);
    }

    /**
     * Relación con Docente (si el usuario es un docente).
     */
    public function docente(): HasOne
    {
        return $this->hasOne(Docente::class);
    }

    // =========================================================================
    // MÉTODOS DE VERIFICACIÓN DE ROLES
    // =========================================================================

    /**
     * Verifica si el usuario es administrador.
     */
    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica si el usuario es docente.
     */
    public function esDocente(): bool
    {
        return $this->role === 'docente';
    }

    /**
     * Verifica si el usuario es estudiante.
     */
    public function esEstudiante(): bool
    {
        return $this->role === 'estudiante';
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     */
    public function tieneRol(string $rol): bool
    {
        return $this->role === $rol;
    }
}