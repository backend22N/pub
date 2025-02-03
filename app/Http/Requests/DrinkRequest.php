<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class DrinkRequest extends FormRequest
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

            "drink" => "required|min:3|max:15|unique:drinks,drink",
            "amount" => "required|numeric",
            "type" => "required",
            "package" => "required"
        ];
    }

    public function messages() {

        return [
            "drink.required" => "Italnév elvárt!",
            "drink.max" => "Túl hosszú név",
            "drink.min" => "Túl rövid név",
            "drink.unique" => "Az adat már létezik",
            "drink.alpha" => "Csak betűk lehetnek.",
            "amount.numeric" => "Mennyiség csak szám lehet.",
            "amount.required" => "Mennyiség elvárt."
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
