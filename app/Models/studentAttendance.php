<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class studentAttendance extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'name',
        'lrn_no',
        'user_id',
        'time_in',
        'time_out'
    ];
    
}
