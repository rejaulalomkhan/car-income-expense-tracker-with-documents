<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDocument extends Model
{
    protected $fillable = [
        'doc_category',
        'doc_name',
        'doc_scancopy',
        'doc_description'
    ];

    public static function getCategories()
    {
        return [
            'Family Documents',
            'Office Documents',
            'Certificates',
            'Land Documents',
            'Others Documents'
        ];
    }
}
