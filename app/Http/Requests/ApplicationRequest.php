<?php

namespace SMT\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'language' => 'required|not_in:0',
            'framework' => 'required|not_in:0',
            'username' => 'required',
            'password' => 'required',
            'host' => 'required',
            'path' => 'required',
        ];
        if ($this->getMethod() == 'PUT') {// Update request
            $rules['name'] = 'required';
        }

        return $rules;
    }
}
