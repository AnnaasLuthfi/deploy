<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{

    public function updateOrCreateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'required',
            'bio' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currentUser = auth()->user();

        $profileData = Profiles::updateOrCreate(
            ['user_id' => $currentUser->id],
            [
                'age' => $request['age'],
                'bio' => $request['bio'],
                'user_id' => $currentUser->id,
            ]
        );

        return response()->json([
            "message" => "Profile berhasil ditambah / diubah",
            "data" => $profileData
        ], 201);
    }
}
