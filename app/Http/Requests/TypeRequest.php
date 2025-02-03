<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TypeRequest extends FormRequest
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

            "type" => "required|max:5|min:2|alpha:acii|unique:types,type",
        ];
    }

    public function messages() {

        return [
            "type.required" => "Mező elvárt!",
            "type.max" => "Túl hosszú név",
            "type.min" => "Túl rövid név",
            "type.alpha" => "Nem lehetnek számok!",
            "type.unique" => "Az adat már létezik"
        ];
    }

    public function failedValidation( Validator $validator ) {

        throw new HttpResponseException( response()->json([

            "success" => false,
            "message" => "Beviteli hiba",
            "data" => $validator->errors()
        ]));
    }
}
