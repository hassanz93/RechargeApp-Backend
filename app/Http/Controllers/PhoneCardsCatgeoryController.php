<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PhoneCardsCategory;

class PhoneCardsCatgeoryController extends Controller
{
    public function index()  // show all
    {
        $phoneCategory = PhoneCardsCategory::all();

        return response()->json([
            'status' => true,
            'data' => $phoneCategory], 201);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'percentageSale' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()], 400);
        }

        $example = new PhoneCardsCategory;
        $example->category = $request->category;
        $example->percentageSale =$request->percentageSale;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully created item'], 201);
    }

    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'category' => 'string|max:255',
            'percentageSale' => 'numeric',
        ]);

      
        $example = PhoneCardsCategory::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'User failed to update'], 400);
        }
        
        $example->category = $request->category ?? $example->category;
        $example->percentageSale = $request->percentageSale ?? $example->percentageSale;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated user'], 200);
    }

    public function destroy($id) // delete data
    {
        $example = PhoneCardsCategory::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => `User can't be deleted`], 400);
        }

        $example->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted user'], 200);
    }
}
