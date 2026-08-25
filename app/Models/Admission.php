<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',

        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'nationality',

        'admission_no',
        'admission_date',

         'class_id',

        'section_id',

        'father_name',
        'mother_name',
        'guardian_name',
        'guardian_phone',
        'guardian_email',

        'address',
        'status',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
