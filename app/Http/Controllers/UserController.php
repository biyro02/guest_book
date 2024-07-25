<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // request eklememin sebebi ileride işimizi görebileceği içindir, belki filtreler eklenir
    public function all(Request $request)
    {
        $users = User::all();
        // data manipülasyonu için gerekli olabilir

        return response()->json(['users' => $users]);
    }
}
