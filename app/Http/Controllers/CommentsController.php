<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function getComments()  // show one
    {
        $allComments = Comments::all();

        $commenstId = collect($allComments)->where('receiverId', Auth::user()->id)->all();

        return response()->json([
            'status' => true,
            'data' => $commenstId], 201);
    }

    public function getLastComment()
    {
        $comment = Comments::where('receiverId', Auth::user()->id)
                           ->orderBy('id', 'desc')
                           ->first();

        return response()->json([
            'status' => true,
            'data' => $comment,
            'message' => 'Successfully showed message'], 201);
    }

    public function store(Request $request)  // save data
    {
      
        $comment = Comments::create([
            'senderId' => $request->Auth::user()->id,
            'receiverId' => $request->receiverId,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully sent message'], 201);
    }
}
