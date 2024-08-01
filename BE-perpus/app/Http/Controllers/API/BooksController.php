<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','isOwner'])->only('store');
        $this->middleware(['auth:api','isOwner'])->only('update');
        $this->middleware(['auth:api','isOwner'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Books::orderBy('created_at', 'DESC')->with('category')->get();
        return response()->json([
            "message" => "tampil data berhasil",
            "data" => $books
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
             $imageName = time().'.'.$request->image->extension();
             $request->image->storeAs('public/images', $imageName);
             $path = env('APP_URL').'/storage/images/';
             $data['image'] = $path.$imageName;
        }

        $books = Books::create($data);

        return response()->json([
            "message" => "Tambah books berhasil",
            "data"=>$books
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $books = Books::with('category','list_borrows')->find($id);
        if (!$books) {
            return response()->json([
                "message" => "books Not Found",
            ], 404);
        }

        return response()->json([
            "message" => "Detail Data books",
            "data" => $books
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        $data = $request->validated();
        $book = Books::find($id);

        if (!$book) {
            return response()->json([
                "message" => "book Not Found",
            ], 404);
        }
        $data = $request->validated();
        $book = Books::find($id);

        if (!$book) {
            return response()->json([
                "message" => "book Not Found",
            ], 404);
        }

        if ($request->hasFile('image')) {

            if ($book->image) {
                $imageName = basename($book->image);
                Storage::delete('public/images/' . $imageName);
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $path = env('APP_URL').'/storage/images/';
            $data['image'] = $path.$imageName;
        }

        $book->update($data);

        return response()->json([
            "message" => "Update book berhasil",
            "data"=>$book
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json([
                "message" => "book Not Found",
            ], 404);
        }

        if ($book->image) {
            $imageName = basename($book->image);
            Storage::delete('public/images/' . $imageName);
        }

        $book->delete();

        return response()->json([
            "message" => "berhasil Menghapus book"
        ], 201);
    }

    public function bookPopular(){
        $limitBooks = Books::orderBy('created_at')->take(5)->with('category')->get();
        return response()->json([
            "message" => "Tampil Limit Books Berhasil",
            "data" => $limitBooks
        ], 201);

    }


}
