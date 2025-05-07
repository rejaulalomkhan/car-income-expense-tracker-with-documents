<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CarDocument extends Model
{
    use HasFactory;

    protected $table = 'car_documents';

    const DOCUMENT_TYPES = [
        'Certificate of Registration' => 'Certificate of Registration',
        'Fitness' => 'Fitness',
        'Tax Token' => 'Tax Token',
        'Insurance' => 'Insurance',
        'Route Permit' => 'Route Permit',
        'Branding' => 'Branding'
    ];

    protected $fillable = [
        'car_id',
        'document_type',
        'document_expiry_date',
        'document_image',
        'document_comment',
        'notification_sent'
    ];

    protected $casts = [
        'document_expiry_date' => 'date',
        'notification_sent' => 'boolean'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getTypeLabel()
    {
        return self::DOCUMENT_TYPES[$this->document_type] ?? $this->document_type;
    }

    public function getStatusAttribute()
    {
        if ($this->document_expiry_date->isPast()) {
            return 'expired';
        } elseif ($this->document_expiry_date->diffInDays(now()) <= 30) {
            return 'expiring_soon';
        }
        return 'valid';
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'expired' => 'Expired',
            'expiring_soon' => 'Expiring Soon',
            'valid' => 'Valid',
            default => 'Unknown'
        };
    }

    public function scopeExpired(Builder $query)
    {
        return $query->where('document_expiry_date', '<', now());
    }

    public function scopeExpiringSoon(Builder $query)
    {
        return $query->whereBetween('document_expiry_date', [now(), now()->addDays(30)]);
    }

    public function scopeValid(Builder $query)
    {
        return $query->where('document_expiry_date', '>', now()->addDays(30));
    }

    public function scopeOfType(Builder $query, string $type)
    {
        return $query->where('document_type', $type);
    }

    public function scopeForCar(Builder $query, int $carId)
    {
        return $query->where('car_id', $carId);
    }
}
