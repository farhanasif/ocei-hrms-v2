<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayCalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leave_id'=>'required',
            'year'=>'required',
            'image'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'leave_id.required' => 'The holiday name field is required.',
            'year.required' => 'The Year field is required.',
            'image.required' => 'The Calendar Image field is required.',
        ];
    }
}
