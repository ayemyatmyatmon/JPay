<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferConfirmationRequest extends FormRequest
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
            'to_phone'=>'required',
            'amount'=>'required',

        ];
    }

    public function messages():array{
        return [
            'to_phone.required'=>'Please Enter To Phone Number',
            'amount.required' =>'Please Enter Amount',
        ];
    }
}
