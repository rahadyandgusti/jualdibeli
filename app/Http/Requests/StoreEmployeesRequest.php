<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class StoreEmployeesRequest extends CrudRequest
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
        $validation['start_at'] = 'required|date';
        $validation['customer_id'] = 'required|numeric';
        
        $id = \Route::current()->parameters();
        
        if(isset($id['employee'])){
            if(! empty(\Request::get('end_at'))){
                $validation['end_at'] = 'date';
                $validation['description_end'] = 'required';
            }
        } 

        return $validation;
    }
}
