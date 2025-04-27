<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\DoctorsAvailability;
use App\Http\Requests\DoctorsAvailabilityRequest;
use App\Models\Api\V1\Appointment;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Jobs\SendAppointmentConfirmation;

/**
 * @OA\Info(
 *     title="Hospital Management API",
 *     version="1.0.0",
 *     description="API documentation for Hospital, Doctor, Patient, and Appointment management system",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 */

class AppointmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/appointments",
     *     summary="List all appointments with optional filters",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="doctor_id",
     *         in="query",
     *         description="Filter by doctor ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="patient_id",
     *         in="query",
     *         description="Filter by patient ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by appointment status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "confirmed", "cancelled"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of appointments"
     *     )
     * )
     */
    public function index(AppointmentRequest $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'hospital']);

        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('hospital_id')) {
            $query->where('', $request->hospital_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/appointments",
     *     summary="Create a new appointment",
     *     tags={"Appointments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     * required={"patient_id", "doctor_id", "status", "date", "time"},
     * @OA\Property(property="patient_id", type="integer"),
     *                     @OA\Property(property="doctor_id", type="integer"),
     *                     @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"}),
     *                     @OA\Property(property="date", type="string", format="date", example="2025-04-25"),
     *                     @OA\Property(property="time", type="string", format="time", example="14:30"),
     *                     @OA\Property(property="notes", type="string", nullable=true),
     *                     @OA\Property(property="hospital_id", type="integer")
     *)
     *            ),   
     *     @OA\Response(response=201, description="Appointment created")
     * )
     */
    public function store(AppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());

        $appointment->load(['patient', 'doctor', 'hospital']);

        if ($appointment->patient && $appointment->patient->email) {
            // Mail::to($appointment->patient->email)->send(new AppointmentConfirmationMail($appointment));
            SendAppointmentConfirmation::dispatch($appointment);

        }

        return response()->json($appointment, 201);
    }

    public function availability(DoctorsAvailabilityRequest $request)
    {
        $available = 
    }

    /**
     * @OA\Get(
     *     path="/api/v1/appointments/{id}",
     *     summary="Get a specific appointment by ID",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Appointment details")
     * )
     */
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor', 'hospital'])->findOrFail($id);
        return response()->json($appointment);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/appointments/{id}",
     *     summary="Update an existing appointment",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="patient_id", type="integer"),
     *             @OA\Property(property="doctor_id", type="integer"),
     *             @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"}),
     *             @OA\Property(property="date", type="string", format="date"),
     *             @OA\Property(property="time", type="integer", format="time"),
     *             @OA\Property(property="notes", type="string", nullable=true),
     *             @OA\Property(property="hospital_id", type="integer"),
     * 
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated appointment")
     * )
     */
    public function update(AppointmentRequest $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->validated());
        return response()->json($appointment);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/appointments/{id}",
     *     summary="Delete an appointment",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Appointment deleted")
     * )
     */
    public function destroy($id)
    {
        Appointment::destroy($id);
        return response()->json(['message' => 'Appointment deleted successfully.']);
    }
}
