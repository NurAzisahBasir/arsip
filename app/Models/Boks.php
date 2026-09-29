<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boks extends Model
{
    use HasFactory;

    protected $fillable = ['rak_id', 'code', 'year_start', 'year_end', 'description'];

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class);
    }

    public function arsips(): HasMany
    {
        return $this->hasMany(Arsip::class, 'boks_id');
    }
}