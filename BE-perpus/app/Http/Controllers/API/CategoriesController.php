<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'isOwner'])->only('store');
        $this->middleware(['auth:api', 'isOwner'])->only('update');
        $this->middleware(['auth:api', 'isOwner'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Categories::orderBy('name', 'Asc')->get();
        return response()->json([
            "message" => "tampil data berhasil",
            "data" => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Categories::create($request->all());
        return response()->json(["message" => "Tambah Category berhasil"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Categories::with('list_books')->find($id);
        if (!$category) {
            return response()->json([
                "message" => "category Not Found",
            ], 404);
        }

        return response()->json([
            "message" => "Detail Data category",
            "data" => $category
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                "message" => "category Not Found",
            ], 404);
        }

        $category->name = $request['name'];

        $category->save();

        return response()->json([
            "message" => "Update category berhasil",
            "data" => $category
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                "message" => "category Not Found",
            ], 404);
        }

        $category->delete();

        return response()->json([
            "message" => "berhasil Menghapus category"
        ], 201);
    }
}
