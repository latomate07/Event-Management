<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_name' => 'required',
            'event_content' => 'required',
            'event_start' => 'required',
            'event_end' => 'required'
        ];
    }
}
