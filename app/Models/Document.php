<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    const CAR_DOCUMENT_TYPES = [
        'registration' => 'Registration Certificate',
        'insurance' => 'Insurance Certificate',
        'inspection' => 'Inspection Certificate',
        'road_tax' => 'Road Tax Certificate',
        'permit' => 'Operating Permit',
    ];

    const COMPANY_DOCUMENT_TYPES = [
        'business_license' => 'Business License',
        'tax_certificate' => 'Tax Certificate',
        'other' => 'Other Legal Document',
    ];

    protected $fillable = [
        'car_id',
        'name',
        'category',
        'type',
        'expiry_date',
        'file_path',
        'description',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public static function getDocumentTypes(?string $category = null)
    {
        if ($category === 'car') {
            return self::CAR_DOCUMENT_TYPES;
        } elseif ($category === 'company') {
            return self::COMPANY_DOCUMENT_TYPES;
        }
        return array_merge(self::CAR_DOCUMENT_TYPES, self::COMPANY_DOCUMENT_TYPES);
    }

    public function getTypeLabel()
    {
        $types = $this->category === 'car' 
            ? self::CAR_DOCUMENT_TYPES 
            : self::COMPANY_DOCUMENT_TYPES;

        return $types[$this->type] ?? $this->type;
    }
} 