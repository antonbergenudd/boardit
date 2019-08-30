<?php

namespace boardit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSubmitRequest extends FormRequest
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
            // 'street' => 'required',
            // 'postcode' => 'required|digits:5',
            // 'city' => 'required',
            // 'tel' => 'required_without:email',
            // 'email' => 'required_without:tel',
        ];
    }
}
