<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Slot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SlotController extends Controller
{
   
    public function availableSlots(Request $request)
    {
        $slots = Slot::where('status', 'available')
            ->when($request->doctor_id, function($query) use ($request) {
                $query->where('doctor_id', $request->doctor_id);
            })
            ->when($request->date, function($query) use ($request) {
                $query->where('date', $request->date);
            })
            ->get();

        return response()->json($slots);
    }

   
    public function bookSlot(Request $request, $slotId)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,id',
    ]);

    $slot = Slot::findOrFail($slotId);

    // Check if slot is already booked or not 
    if ($slot->status == 'booked') {
        return response()->json(['message' => 'Slot has been already booked'], 400);
    }

    if ($slot->date < date('Y-m-d')) {
        return response()->json(['message' => 'Cannot book past the date slot'], 400);
    }

    $slot->update([
        'patient_id' => $request->patient_id,
        'status' => 'booked',
    ]);

    return response()->json(['message' => 'Slot is now booked successfully']);
}

public function cancelSlot($slotId)
{
    $slot = Slot::findOrFail($slotId);

    if ($slot->status == 'available') {
        return response()->json(['message' => 'Slot is already available'], 400);
    }

    $slot->update([
        'patient_id' => null,
        'status' => 'available',
    ]);

    return response()->json(['message' => 'Slot cancelled successfully']);
}

}

