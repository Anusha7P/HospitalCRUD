<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Models\Api\V1\Patient;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class PatientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/patients",
     *     summary="Get all patients",
     *     tags={"patient"},
     *     @OA\Response(
     *         response=200,
     *         description="List of patient"
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Patient::all());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patients",
     *     summary="Create a new patient",
     *     tags={"patient"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "address", "DOB", "gender", "hospital_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="DOB", type="date"),
     *             @OA\Property(property="gender", type="string", format="enum"),
     *             @OA\Property(property="hospital_id", type="integer"),
     * 
     * 
     * 
     * 
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully"
     *     )
     * )
     */
    public function store(PatientRequest $request)
    {
        $validated = $request->validated();
        $patient = Patient::create($validated);
        return response()->json($patient, 201);
    }



    /**
     * @OA\Get(
     *     path="/api/v1/patients/{id}",
     *     summary="Get a Patient by ID",
     *     tags={"patient"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Patient",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient data retrieved"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $patient = Patient::find($id);
        return response()->json($patient, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/patients/{id}",
     *     summary="Update a patient",
     *     tags={"patient"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the patient to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "address", "DOB", "gender", "hospital_id"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="DOB", type="date"),
     *             @OA\Property(property="gender", type="string", format="enum"),
     *             @OA\Property(property="hospital_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully"
     *     )
     * )
     */



    public function update(PatientRequest $request, string $id)
    {
        $validated = $request->validated();
        $patient = Patient::findOrFail($id);
        $patient->update($validated);
        return response()->json($patient, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/patients/{id}",
     *     summary="Delete a Patient",
     *     tags={"patient"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Patient to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Patient deleted successfully"
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json($patient, 200);
    }
}
