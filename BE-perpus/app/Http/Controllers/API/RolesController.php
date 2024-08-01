<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','isOwner'])->only('index');
        $this->middleware(['auth:api','isOwner'])->only('store');
        $this->middleware(['auth:api','isOwner'])->only('update');
        $this->middleware(['auth:api','isOwner'])->only('destroy');
    }

    public function index()
    {
        $role = Roles::orderBy('updated_at', 'DESC')->get();
        return response()->json([
            "message" => "tampil data berhasil",
            "data" => $role
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

        Roles::create($request->all());
        return response()->json(["message" => "Tambah role berhasil"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
                "message" => "Role Not Found",
            ], 404);
        }

        $role->name = $request['name'];

        $role->save();

        return response()->json([
            "message" => "Update Role berhasil",
            "data"=>$role
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
                "message" => "Role Not Found",
            ], 404);
        }

        $role->delete();

        return response()->json([
            "message" => "berhasil Menghapus Role"
        ], 201);
    }
}
