<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGenreRequest extends FormRequest
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
            //
            'genre' => 'required|max:20',
        ];
    }

    public function messages()
    {
        return [
            'genre.required' => '入力してください',
            'genre.max' => '20文字以内で入力してください',
          ];
    }
}
