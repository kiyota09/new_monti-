<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'position',
        'newsletter_opt_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'newsletter_opt_in' => 'boolean',
        ];
    }

    /**
     * Scope for HRM users.
     */
    public function scopeHrm(Builder $query): Builder
    {
        return $query->where('role', 'hrm');
    }

    /**
     * Scope for SCM users.
     */
    public function scopeScm(Builder $query): Builder
    {
        return $query->where('role', 'scm');
    }

    /**
     * Scope for HRM staff (non-managers).
     */
    public function scopeHrmStaff(Builder $query): Builder
    {
        return $query->where('role', 'hrm')->where('position', 'staff');
    }

    /**
     * Scope for SCM staff (non-managers).
     */
    public function scopeScmStaff(Builder $query): Builder
    {
        return $query->where('role', 'scm')->where('position', 'staff');
    }

    /**
     * Scope for managers.
     */
    public function scopeManagers(Builder $query): Builder
    {
        return $query->where('position', 'manager');
    }

    /**
     * Scope for staff (non-managers).
     */
    public function scopeStaff(Builder $query): Builder
    {
        return $query->where('position', 'staff');
    }

    /**
     * Scope for ordering by name.
     */
    public function scopeOrderByName(Builder $query): Builder
    {
        return $query->orderBy('first_name');
    }

    /**
     * Check if user is HRM.
     */
    public function isHrm(): bool
    {
        return $this->role === 'hrm';
    }

    /**
     * Check if user is SCM.
     */
    public function isScm(): bool
    {
        return $this->role === 'scm';
    }

    /**
     * Check if user is a manager.
     */
    public function isManager(): bool
    {
        return $this->position === 'manager';
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return $this->position === 'staff';
    }

    /**
     * Get user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Get display name for role.
     */
    public function getRoleDisplayAttribute(): string
    {
        return $this->isHrm() ? 'HRM' : 'SCM';
    }

    /**
     * Get display name for position.
     */
    public function getPositionDisplayAttribute(): string
    {
        return $this->isManager() ? 'Manager' : 'Staff';
    }
}
