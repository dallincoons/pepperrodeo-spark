<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecipeRequest extends FormRequest
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
            'category' => 'required|string',
            'title' => [
                'required',
                'string',
                Rule::unique('recipes')->where(function($query){
                    $query->where('user_id', \Auth::user()->getKey());
                })
            ],
            'directions' => 'required|string',
            'recipeFields.*.type' => 'required',
            'recipeFields.*.name' => 'required',
            'recipeFields.*.item_category_id' => 'required',
            'recipeFields.*.quantity' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'recipeFields.*.type.required' => 'Item type is missing',
            'recipeFields.*.name.required' => 'Item name is missing',
            'recipeFields.*.item_category_id.required' => 'Item category is missing',
            'recipeFields.*.quantity.required' => 'Item quantity is missing',
        ];
    }
}
