<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(ClassModel::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
