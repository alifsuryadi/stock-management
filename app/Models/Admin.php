<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'birth_date',
        'gender',
        'password',
        'slug',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            $admin->slug = Str::slug($admin->first_name . '-' . $admin->last_name) . '-' . time();
        });

        static::updating(function ($admin) {
            if ($admin->isDirty(['first_name', 'last_name'])) {
                $admin->slug = Str::slug($admin->first_name . '-' . $admin->last_name) . '-' . time();
            }
        });
    }
}