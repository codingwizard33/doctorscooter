<?php

namespace App\Http\Requests\RepairOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'model' => 'required',
            'price' => 'required',
            'bar_code' => 'nullable',
            'information' => 'required',
            'payment_comment' => 'required',
            'payment_option' => 'required',
            'payment_warranty' => 'required',
            'payment_status' => 'nullable',
            'images' =>'array',
        ];
    }
}
