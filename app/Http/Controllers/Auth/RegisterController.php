<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Check if 'Admin' role exists, if not, create it
        $adminRole = Role::where('slug', 'admin')->first();
        if (!$adminRole) {
            $adminRole = Role::create([
                'slug' => 'admin',
                'name' => 'Administrator',
                'permissions' => null,
            ]);

            // Assign the 'Admin' role to the first registered user
            $user->roles()->attach($adminRole);
        } else {
            // 'Admin' role exists, so create or retrieve 'Faculty' role
            $facultyRole = Role::where('slug', 'faculty')->first();
            if (!$facultyRole) {
                $facultyRole = Role::create([
                    'slug' => 'faculty',
                    'name' => 'Faculty',
                    'permissions' => null,
                ]);
            }

            // Assign the 'Faculty' role to subsequent registered users
            $user->roles()->attach($facultyRole);
        }

        return $user;
    }
}
