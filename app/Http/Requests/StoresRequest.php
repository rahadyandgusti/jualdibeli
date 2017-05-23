<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class StoresRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation['name'] = 'required|min:5|max:255';
        $validation['owner_id'] = 'required|numeric';

        return $validation;
    }
}
