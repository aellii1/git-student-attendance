<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Gender extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'gender'
    ];
}
