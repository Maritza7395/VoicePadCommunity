<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatAddPictureDefaultRequest extends FormRequest
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
            'avatarM' => 'image|mimes:jpg,png,jpeg|dimensions:min_width=100,min_height=200',
            'avatarF' => 'image|mimes:jpg,png,jpeg|dimensions:min_width=100,min_height=200',
            'cover' => 'image|mimes:jpg,png,jpeg|dimensions:min_width=100,min_height=200',
        ];
    }
}
