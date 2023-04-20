<?php

namespace App\Http\Requests\Lesson;

use App\Exceptions\DomainException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateLessonRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'min:5|required|string|max:255',
            'lesson_order' => 'required|integer'
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new DomainException($validator->messages()->all(), 422);
    }
}