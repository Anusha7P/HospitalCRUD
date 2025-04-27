<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorsAvailabilityRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|afer_or_equal:today',
            'duration' => 'required|integer|min:1'
        ];
    }

     /**
     * Get custom error messages for the validator.
     *
     * @return array
     */

     public function messages()
     {
         return [
             'doctor_id.required' => 'Doctor is required.',
             'doctor_id.exists' => 'The selected doctor does not exist.',
             'appointment_date.required' => 'Appointment date is required.',
             'appointment_date.date' => 'Appointment date must be a valid date.',
             'appointment_date.after_or_equal' => 'Appointment date must be today or in the future.',
             'duration.required' => 'Duration is required.',
             'duration.integer' => 'Duration must be an integer.',
             'duration.min' => 'Duration must be at least 1 minute.',
         ];
     }
}
