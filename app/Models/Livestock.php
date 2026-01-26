<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Livestock extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Fields that can be mass-assigned
    protected $fillable = [
        'owner',
        'veterinarian',
        'name',
        'date_of_birth',
        'species',
        'tag',
        'picture'
    ];

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function medicalTreatments()
    {
        return $this->hasMany(MedicalTreatment::class);
    }
}


