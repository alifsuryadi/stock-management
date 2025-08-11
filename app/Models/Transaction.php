<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'type',
        'notes',
        'admin_id',
        'transaction_date',
        'slug',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->transactionDetails->sum('quantity');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->slug = Str::slug($transaction->transaction_code);
        });
    }
}