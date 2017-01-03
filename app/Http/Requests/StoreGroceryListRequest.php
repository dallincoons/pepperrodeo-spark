<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroceryListRequest extends FormRequest
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
            'title'                    => 'required|string',
            'items'                    => 'required|array',
            'items.*.quantity'         => 'required',
            'items.*.name'             => 'required|string',
            'items.*.department_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'items.*.name.required' => 'Item name is missing',
            'items.*.department_id.required' => 'Department is missing',
            'items.*.quantity.required' => 'Item quantity is missing',
        ];
    }
}
