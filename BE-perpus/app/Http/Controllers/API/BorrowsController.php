<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Borrows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','isOwner'])->only('index');
    }
    public function index()
    {
        $borrow = Borrows::with('user','books')->get();
        return response()->json([
            "message" => "tampil data berhasil",
            "data" => $borrow
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function CreateOrUpdateBorrow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'load_date' => 'required|date',
            'borrow_date' => 'required|date',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $currentUser = auth()->user();

        $comments = Borrows::updateOrCreate(
            [
                'user_id' => $currentUser->id,
                'book_id' => $request['book_id'],
            ],
            [
                'load_date' => $request['load_date'],
                'borrow_date' => $request['borrow_date'],
            ]
        );

        return response()->json([
            "message" => "Tambah / Update berhasil",
            "data" => $comments
        ], 201);
    }

}
