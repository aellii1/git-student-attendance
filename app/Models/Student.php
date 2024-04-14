<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Student extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'gender',
        'birthdate',
        'ctn_no',
        'email',
        'section',
        'track',
        'gr_lvl'
    ];
}
