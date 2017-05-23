<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class CustomersRequest extends CrudRequest
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
        $validation['password_confirmation'] = 'max:255';
        
        $id = \Route::current()->parameters();
        
        if(isset($id['customer'])){
            if(! empty(\Request::get('password')))
                $validation['password'] = 'confirmed|alpha_dash|max:255';
            $validation['username'] = 'required|min:5|max:255|unique:customers,username'.
                            ','.$id['customer'].',id';
            $validation['email'] = 'required|min:5|max:255|unique:customers,email'.
                            ','.$id['customer'].',id';
        } else {
            $validation['password'] = 'required|confirmed|alpha_num|min:5|max:255';
            $validation['username'] = 'required|min:5|max:255|unique:customers,username';
            $validation['email'] = 'required|min:5|max:255|unique:customers,email';
        }

        return $validation;
    }
}
