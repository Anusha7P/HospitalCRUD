<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewappointmentRequest;
use App\Models\Api\V2\Appointment;
use App\Models\Api\V2\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments, with optional filters.
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'hospital', 'slot']);

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        if ($request->has('slot_id')) {
            $query->where('slot_id', $request->slot_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created appointment after validating the slot.
     */
    public function store(NewappointmentRequest $request)
    {
        $validated = $request->validated();

        $slot = Slot::findOrFail($validated['slot_id']);

        if ($slot->is_booked) {
            return response()->json(['error' => 'Slot is already booked'], 409);
        }

        // Optional check: slot matches doctor & hospital
        $schedule = $slot->schedule;
        if ($schedule->doctor_id != $validated['doctor_id'] || $schedule->hospital_id != $validated['hospital_id']) {
            return response()->json(['error' => 'Slot does not belong to the given doctor or hospital'], 422);
        }

        // Safe transaction
        DB::transaction(function () use (&$appointment, $validated, $slot) {
            $appointment = Appointment::create($validated);
            $slot->update(['is_booked' => true]);
        });

        return response()->json($appointment->load(['patient', 'doctor', 'hospital', 'slot']), 201);
    }

    /**
     * Display the specified appointment.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient', 'doctor', 'hospital', 'slot'])->findOrFail($id);
        return response()->json($appointment, 200);
    }

    /**
     * Update the specified appointment.
     */
    public function update(NewappointmentRequest $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validated = $request->validated();

        // Prevent slot change to an already booked one
        if (isset($validated['slot_id']) && $validated['slot_id'] != $appointment->slot_id) {
            $newSlot = Slot::findOrFail($validated['slot_id']);

            if ($newSlot->is_booked) {
                return response()->json(['error' => 'New slot is already booked'], 409);
            }

            DB::transaction(function () use ($appointment, $validated, $newSlot) {
                // Free old slot
                $appointment->slot->update(['is_booked' => false]);

                // Book new one
                $newSlot->update(['is_booked' => true]);

                $appointment->update($validated);
            });
        } else {
            $appointment->update($validated);
        }

        return response()->json($appointment->load(['patient', 'doctor', 'hospital', 'slot']), 200);
    }

    /**
     * Remove the specified appointment and free the slot.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Free the slot
        if ($appointment->slot) {
            $appointment->slot->update(['is_booked' => false]);
        }

        $appointment->delete();

        return response()->json(['message' => 'Deleted user appointment'], 200);
    }
}
