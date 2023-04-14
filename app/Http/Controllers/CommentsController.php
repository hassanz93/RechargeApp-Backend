<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function getComments()
    
    {
        $allComments = Comments::where('created_at', '>', Carbon::now()->subWeek())->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $allComments], 201);
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
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully sent message'], 201);
    }

}
