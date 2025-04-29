<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewappointmentRequest;
use App\Models\Api\V2\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $query = Appointment::with(['patient', 'doctor', 'hospital', 'slot']);

        // if ($request->has('doctor_id')) {
        //     $query->where('doctor_id', $request->doctor_id);
        // }

        // if ($request->has('patient_id')) {
        //     $query->where('patient_id', $request->patient_id);
        // }

        // if ($request->has('hospital_id')) {
        //     $query->where('hospital_id', $request->hospital_id);  // Fixed the query
        // }

        // if ($request->has('slot_id')) {
        //     $query->where('slot_id', $request->slot_id);
        // }

        // if ($request->has('status')) {
        //     $query->where('status', $request->status);
        // }
        // // $appointment = Appointment::create($request->all());

        // return response()->json($query->get());

        return response()->json(Appointment::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewappointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());
        return response()->json($appointment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->validated());
        return response()->json($appointment,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(['message'=>'Deleted Users Appointments'],0);

    }
}
