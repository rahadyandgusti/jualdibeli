<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\CustomersRequest as StoreRequest;
use App\Http\Requests\CustomersRequest as UpdateRequest;

class CustomersController extends CrudController
{

    public function setup() {
        $this->crud->setModel("App\Extras\Models\Customers");
        $this->crud->setRoute("admin/customer");
        $this->crud->setEntityNameStrings('Customer', 'Customers');

        // column in index table
        $this->crud->setColumns([
        	[
				'name' => 'name', 
				'label' => "Name", 
			],
        	[
				'name' => 'email', 
				'label' => "E-Mail", 
			],
        	[
				'name' => 'phone', 
				'label' => "Phone Number", 
			]
        ]);

        // field tha use in form input / update
        $this->crud->addField(
			[
				'name' => 'name',
				'label' => "Name"
			]);
        $this->crud->addField(
			[
				'name' => 'username',
				'label' => "Username"
			]);
        $this->crud->addField(
			[
				'name' => 'email',
				'label' => "E-Mail",
				'type' => 'email'
			]);
        $this->crud->addField(
			[
				'name' => 'phone',
				'label' => "Phone",
			]);
        $this->crud->addField(
			[
				'name' => 'password',
				'label' => "Password",
				'type' => 'password'
			]);
        $this->crud->addField(
			[
				'name' => 'password_confirmation',
				'label' => "Password Confirmation",
				'type' => 'password'
			]);
    }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud($request,['password_confirmation']);
	}

	public function update(UpdateRequest $request)
	{
		$exception = ['password_confirmation'];

		if(empty($request->password)) $exception[] = 'password';
		
		return parent::updateCrud($request,$exception);
	}

	public function getDataAjax(Request $request,$id = 0){
		if($id == 0){
			$search_term = $request->input('q');
	        $page = $request->input('page');

	        if ($search_term)
	        {
	            $results = $this->crud->model->where('name', 'ILIKE', '%'.$search_term.'%')->paginate(10);
	        }
	        else
	        {
	            $results = $this->crud->model->paginate(10);
	        }

	        return $results;
		} else {
			return $this->crud->model->find($id);
		}
	}

	public function getOwnerOption() {
		$term = $this->request->input('term');

		$options = $this->crud->model->where('name', 'ilike', '%'.$term.'%')->get();

		return $options->pluck('name', 'id');
	}
}
