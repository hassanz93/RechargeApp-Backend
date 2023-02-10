<?php

namespace App\Http\Controllers;

use App\Models\PhoneCardsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneCardsDetailsController extends Controller
{

    public function index()  // show all
    {
        $phoneDetails = PhoneCardsDetails::all();

        return response()->json([
            'status' => true,
            'data' => $phoneDetails], 201);
    }





 
}
