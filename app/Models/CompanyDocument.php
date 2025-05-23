<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_type_id',
        'title',
        'issue_date',
        'expiry_date',
        'document_file',
        'description',
        'is_active',
        'notification_sent'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'notification_sent' => 'boolean'
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function getTypeLabel()
    {
        return $this->documentType ? $this->documentType->name : 'Unknown';
    }
}
