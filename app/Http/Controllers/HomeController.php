<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Home;

class HomeController extends Controller
{
    public function index()  // show all
    {
        $user = Home::all();

        return response()->json([
            'status' => true,
            'data' => $user], 201);
    }
}
