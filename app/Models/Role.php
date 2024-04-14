<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Role extends Model
{
    use Uuids;

    protected $fillable = [
        'slug', 
        'name', 
        'permissions'
    ];
    
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_users', 'role_id', 'user_id');
    }
}
