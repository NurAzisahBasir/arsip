<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    use HasFactory;

    protected $fillable = [
        'boks_id',
        'archive_number',
        'title',
        'document_type',
        'year',
        'description',
        'file_path',
    ];

    public function boks(): BelongsTo
    {
        return $this->belongsTo(Boks::class, 'boks_id');
    }
}