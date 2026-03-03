<?php

namespace App\Http\Controllers;

use App\Models\JenisTenaga;
use Illuminate\Http\Request;

class JenisTenagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return all jenis tenaga entries
        return JenisTenaga::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_tenaga' => 'required|string|max:255',
        ]);

        $jenisTenaga = JenisTenaga::create($validated);

        return response()->json($jenisTenaga, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisTenaga $jenisTenaga)
    {
        return $jenisTenaga;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisTenaga $jenisTenaga)
    {
        $validated = $request->validate([
            'jenis_tenaga' => 'required|string|max:255',
        ]);

        $jenisTenaga->update($validated);

        return response()->json($jenisTenaga);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisTenaga $jenisTenaga)
    {
        $jenisTenaga->delete();

        return response()->noContent();
    }
}
