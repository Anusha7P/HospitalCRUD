<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Api\V2\Slot;
use Illuminate\Support\Carbon;
use App\Models\Api\V1\Schedule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateSlotRequest;


class SlotController extends Controller
{
    public function generate(GenerateSlotRequest $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);

        $startDate = Carbon::parse($schedule->start_date);
        $endDate = Carbon::parse($schedule->end_date);
        $slots = [];

        DB::transaction(function () use ($schedule, $startDate, $endDate, &$slots) {
            for (
                $date = $startDate->copy();
                $date->lte($endDate);
                $date->addDay()
            ) {
                // Generate slots for all dates between start_date and end_date
                $startTime = Carbon::parse($schedule->start_time);
                $endTime = Carbon::parse($schedule->end_time);
                //making slots from the everyday working hour
                while ($startTime->lt($endTime)) {
                    $slotEnd = $startTime->copy()->addMinutes(15);
                    if ($slotEnd->gt($endTime))
                        break;

                    $slots[] = Slot::create([
                        'schedule_id' => $schedule->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $startTime->format('H:i:s'),
                        'end_time' => $slotEnd->format('H:i:s'),
                    ]);

                    $startTime = $slotEnd;
                }
            }
        });

        return response()->json([
            'message' => 'Slots generated successfully.',
            'slots_created' => count($slots),
        ], 201);
    }

    public function available($doctorId)
    {
        $query = Slot::whereHas('schedule', function ($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->where('is_booked', false);

        // Optional date filters
        if (request()->has('date')) {
            $query->where('date', request()->date);
        } elseif (request()->has('start_date') && request()->has('end_date')) {
            $query->whereBetween('date', [request()->start_date, request()->end_date]);
        }

        $slots = $query->get();

        return response()->json($slots);
    }

//this just showed the available slot of all schedule entered. 
    // public function available($doctorId)
    // {
    //     $slots = Slot::whereHas('schedule', function ($q) use ($doctorId) {
    //         $q->where('doctor_id', $doctorId);
    //     })->where('is_booked', false)->get();

    //     return response()->json($slots);
    // }
}

