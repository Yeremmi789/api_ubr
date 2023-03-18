<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $personal = Personal::all();
        return \response($personal);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $request->validate([
        //     'name'=>'required|max:30',
        //     'email'=> 'required',
        //     'password'=> 'required',
        // ]);

        // $personal = Personal::create($request->all());
        // return \response($personal);


        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'email' => 'required|string|max:255',
            'password' => 'required|string|max:8'
        ]);

        $user = Personal::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $personal = Personal::findOrFail($id);
        return \response($personal);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personal $personal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $pedir_personal = Personal::findOrFail($id)->update($request->all());
        // return \response($pedir_personal);
        return \response(content: "El trabajador ha sido actualizado");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Personal::destroy($id);
        return \response(content: "La persona con el id: $id ha sido eliminada :(");
    }
}
