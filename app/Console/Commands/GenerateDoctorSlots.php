<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\V1\Doctor;
use App\Models\Api\V1\Slot;
use Carbon\Carbon;

class GenerateDoctorSlots extends Command
{
    protected $signature = 'generate:slots {date?}';
    protected $description = 'Generate time slots for doctors based on their schedule';

    public function handle()
    {
        $dateInput = $this->argument('date');
        $date = $dateInput ? Carbon::parse($dateInput) : now();

        $doctors = Doctor::with('schedules')->get();

        foreach ($doctors as $doctor) {
            $dayOfWeek = strtolower($date->format('l')); // like 'monday'
            $schedule = $doctor->schedules->where('day', $dayOfWeek)->first();

            if (!$schedule) {
                continue; // No schedule for today
            }

            // Check if doctor is on leave
            if ($doctor->leaves()->where('date', $date->toDateString())->exists()) {
                continue;
            }

            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);

            while ($startTime < $endTime) {
                Slot::create([
                    'doctor_id' => $doctor->id,
                    'date' => $date->toDateString(),
                    'start_time' => $startTime->format('H:i:s'),
                    'end_time' => $startTime->copy()->addMinutes(15)->format('H:i:s'),
                    'status' => 'available',
                ]);
                $startTime->addMinutes(15);
            }
        }

        $this->info('Slots generated successfully for ' . $date->toDateString());
    }
}
