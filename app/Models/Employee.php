<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'age',
        'email',
        'date_of_birth',
        'address',
        'photo',
    ];

    /**
     * Formatting user-friendly dates.
     *
     * @param [type] $value
     * @return void
     */
    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('d M, Y');
    }
}
