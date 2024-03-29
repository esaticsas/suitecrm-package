<?php

namespace Esatic\Suitecrm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSuitecrmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'method' => ['required'],
            'rest_data' => ['required']
        ];
    }
}
