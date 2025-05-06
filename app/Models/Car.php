<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'model',
        'year',
        'color',
        'photo',
        'status'
    ];

    public function documents()
    {
        return $this->hasMany(CarDocument::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function getTotalIncomeAttribute()
    {
        return $this->incomes()->sum('amount');
    }

    public function getTotalExpenseAttribute()
    {
        return $this->expenses()->sum('amount');
    }

    public function getNetIncomeAttribute()
    {
        return $this->total_income - $this->total_expense;
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive(Builder $query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeHasExpiredDocuments(Builder $query)
    {
        return $query->whereHas('documents', function ($query) {
            $query->where('document_expiry_date', '<', now());
        });
    }

    public function scopeHasExpiringDocuments(Builder $query)
    {
        return $query->whereHas('documents', function ($query) {
            $query->whereBetween('document_expiry_date', [now(), now()->addDays(30)]);
        });
    }

    public function getExpiredDocumentsAttribute()
    {
        return $this->documents()->expired()->get();
    }

    public function getExpiringDocumentsAttribute()
    {
        return $this->documents()->expiringSoon()->get();
    }
}
