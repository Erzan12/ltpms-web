<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccination extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'livestock_id',
        'date',
        'vaccination',
        'booster',
        'user_id'
    ];

    // Define the relationship with the Livestock model
    public function livestock()
    {
        return $this->belongsTo(Livestock::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
