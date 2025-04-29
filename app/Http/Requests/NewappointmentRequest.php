<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewappointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hospital_name' => 'required|exists:hospitals,name',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'nullable|exists:patients,id',
            'slots_id'=>'required|exists:slots,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'date_time'=> 'nullable|date_format:Y:m:d:H:i',
            'notes' => 'nullable|string',
           
        ];
    }
}
