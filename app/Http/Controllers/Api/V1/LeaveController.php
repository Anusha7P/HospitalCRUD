<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Leave::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'leave_date' => 'required|date',
        ]);

        $leave = Leave::create($validated);

        return response()->json($leave, 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leave = Leave::findOrFail($id);
        return response()->json($leave,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Leave::destroy($id);
        return response()->json(['message' => 'Leave removed!'],200);
    }
}
