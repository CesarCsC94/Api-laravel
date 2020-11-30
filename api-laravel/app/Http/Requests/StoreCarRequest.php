<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCarRequest extends FormRequest
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
            'title'         => 'required',
            'description'   => 'required',
            'status'        => 'required',
            'price'         => 'required',
        ];
    }
  
    protected function failedValidation(Validator $validator) 
    {
        throw new HttpResponseException(response()->json([
            'errors'    => $validator->errors(),
            'ok'        => false
        ], 422));
    }
}
