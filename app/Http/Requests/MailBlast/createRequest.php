<?php

namespace App\Http\Requests\MailBlast;

use Illuminate\Foundation\Http\FormRequest;

class createRequest extends FormRequest
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
            'memberEmail.*' => 'required|email',
            'subject'     => 'required|string|min:3',
            'content'     => 'required|min:3',
        ];
    }
}
