<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressUpdateRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'street' => ["max:200", "nullable"],
            'city' => ["max:100", "nullable"],
            'province' => ["max:100", "nullable"],
            'country' => ["max:100", "required"],
            'postal_code' => ["max:10", "nullable"],
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response([
            'errors' => $validator->getMessageBag()
        ], 400));
    }
}
