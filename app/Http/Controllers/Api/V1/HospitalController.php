<?php

namespace App\Http\Controllers\Api\V1;

use OpenApi\Annotations as OA;
use App\Models\Api\V1\Hospital;
use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalRequest;


/**
 * @OA\Info(
 *     title="Hospital Management API",
 *     version="1.0.0",
 *     description="API documentation for the Hospital Management system"
 * )
 */

/**
 *  @OA\Tag(
 * name = "Hospital Management",
 * description="API Endpoints for the Hospital List"
 * 
 * )
 */

class HospitalController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/hospitals",
     *     summary="Get all Hospitals Details",
     *     tags={"Hospital"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Hospitals"
     *     )
     * )
     */
    public function index()
    {

        return response()->json(Hospital::all());
    }


    /**
     * @OA\Post(
     *     path="/api/v1/hospitals",
     *     summary="Create a new Hospital",
     *     tags={"Hospital"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "contact", "type", "services"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="contact", type="integer"),
     *             @OA\Property(property="type", type="string", format="enum"),
     *             @OA\Property(property="services", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hospital created successfully"
     *     )
     * )
     */

    public function store(HospitalRequest $request)
    {
        $validated = $request->validated();
        $hospital = Hospital::create($validated);
        return response()->json($hospital, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/hospitals/{id}",
     *     summary="Get a Hospital by ID",
     *     tags={"Hospital"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Hospital",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital data retrieved"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hospital not found"
     *     )
     * )
     */


    public function show(string $id)
    {
        $hospital = Hospital::findOrFail($id);
        return response()->json($hospital, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/hospitals/{id}",
     *     summary="Update a Hospital",
     *     tags={"Hospital"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Hospital to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="contact", type="integer"),
     *             @OA\Property(property="type", type="string", format="enum"),
     *             @OA\Property(property="services", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hospital updated successfully"
     *     )
     * )
     */


    public function update(HospitalRequest $request, string $id)
    {
        $validated = $request->validated();
        $hospital = Hospital::findOrFail($id);
        $hospital->update($validated);
        $hospital->update($request->all());

        return response()->json($hospital);
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/hospitals/{id}",
     *     summary="Delete a Hospital",
     *     tags={"Hospital"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Hospital to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Hospital deleted successfully"
     *     )
     * )
     */


    public function destroy(string $id)
    {
        Hospital::destroy($id);
        return response()->json(['message' => 'Hospital deleted']);
    }
}
