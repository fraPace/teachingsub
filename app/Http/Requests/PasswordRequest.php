<?php

namespace App\Http\Requests;

use App\Course;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current-password' => 'required|different:password',
            'password' => 'required|string|min:6|confirmed'
        ];
    }
}
