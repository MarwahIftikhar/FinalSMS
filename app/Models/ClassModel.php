<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassModel extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'status',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    protected $casts = [
        'status' => 'boolean',
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class, 'class_id');
    }
}
