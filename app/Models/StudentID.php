<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class StudentID extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [ 
        'id',
        'std_id',
        'student_no',
    ];
}
