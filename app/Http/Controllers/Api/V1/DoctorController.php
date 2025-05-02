<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Api\V1\Doctor;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;


/**
 * @OA\Info(
 *     title="Hospital Management API",
 *     version="1.0.0",
 *     description="API documentation for the Hospital Management system"
 * )
 */

/**
 * @OA\Tag(
 *     name="Doctor",
 *     description="API Endpoints for Managing doctors"
 * )
 */

class DoctorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/doctors",
     *     summary="Get all doctors",
     *     tags={"doctor"},
     *     @OA\Response(
     *         response=200,
     *         description="List of doctors"
     *     )
     * )
     */

    public function index()
    {
        return response()->json(Doctor::all());
    }



    /**
     * @OA\Post(
     *     path="/api/v1/doctors",
     *     summary="Create a new doctor",
     *     tags={"doctor"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "specialization", "hospital_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="phone", type="integer"), 
     *             @OA\Property(property="specialization", type="string", format="enum"), 
     *             @OA\Property(property="Hospital_id", type="integer"), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Doctor created successfully"
     *     )
     * )
     */
    public function store(DoctorRequest $request)
    {
        $validated = $request->validated();
        $doctor = Doctor::create($validated);
        return response()->json($doctor, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/doctors/{id}",
     *     summary="Get a doctor by ID",
     *     tags={"doctor"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the doctor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="doctor data retrieved"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="doctor not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $doctor = Doctor::find($id);
        return response()->json($doctor, 200);
    }


    /**
     * @OA\Put(
     *     path="/api/v1/doctors/{id}",
     *     summary="Update a doctor",
     *     tags={"doctor"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the doctor to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="phone", type="integer"), 
     *             @OA\Property(property="specialization", type="string", format="enum"), 
     *             @OA\Property(property="Hospital_id", type="integer"), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="doctor updated successfully"
     *     )
     * )
     */

    public function update(DoctorRequest $request, string $id)
    {
        $validated = $request->validated();
        $doctor = Doctor::findOrFail($id);
        $doctor->update($validated);
        return response()->json($doctor);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/doctors/{id}",
     *     summary="Delete a doctor",
     *     tags={"doctor"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the doctor to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="doctor deleted successfully"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        Doctor::destroy($id);
        return response()->json(['message' => 'Doctor information deleted successfully']);
    }
}
