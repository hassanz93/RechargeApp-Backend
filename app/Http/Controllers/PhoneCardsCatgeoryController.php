<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneCardsCategory;

class PhoneCardsCatgeoryController extends Controller
{
    public function index()  // show all
    {
        $user = PhoneCardsCategory::all();

        return response()->json([
            'status' => true,
            'data' => $user], 201);
    }
}
