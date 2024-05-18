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
        'picture',
        'user_id',
        'lrn_no',
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
