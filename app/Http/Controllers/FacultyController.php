<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class FacultyController extends Controller
{
    public function index() {

        $user = auth()->user();

        return view('faculty.index', [
            'user' => $user,
        ]);
        
    }
}
