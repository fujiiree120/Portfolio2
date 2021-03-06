<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTriviaRequest extends FormRequest
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
            'name' => 'required|max:20',
            'body' => 'required|max:200',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '雑学を入力してください',
            'name.max' => '20文字以内で雑学を入力してください',
            'body.required' => '内容を入力してください',
            'body.max' => '200文字以内で内容を入力してください',
          ];
    }
}
