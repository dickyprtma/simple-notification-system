<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coop;
use Illuminate\Http\Request;

class CoopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coops = Coop::with('user')->get();
        return response()->json($coops);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'temp' => 'required|numeric',
        ]);

        $coop = Coop::create($validated);

        return response()->json($coop, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coop = Coop::findOrFail($id);
        return response()->json($coop);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coop = Coop::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'temp' => 'sometimes|numeric',
        ]);

        $coop->update($validated);

        return response()->json($coop);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coop = Coop::findOrFail($id);
        $coop->delete();

        return response()->json(['message' => 'Coop deleted successfully']);
    }
}
