<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\StoresRequest as StoreRequest;
use App\Http\Requests\StoresRequest as UpdateRequest;

class StoresController extends CrudController
{

    public function setup() {
    	
        $this->crud->setModel("App\Extras\Models\Stores");
        $this->crud->setRoute("admin/store");
        $this->crud->setEntityNameStrings('Store', 'Stores');



        // column in index table
        $this->crud->setColumns([
        	[
				'name' => 'name', 
				'label' => "Name", 
			],
        	[
				'name' => 'owner_id', 
				'label' => "Owner", 
				'type' => "select",
				'entity' => 'owner',
				'attribute' => "name",
				'model' => "App\Extras\Models\Customers", 
			],
        	[
				'name' => 'description', 
				'label' => "Description", 
			],
        	[
				'name' => 'created_at', 
				'label' => "Created At", 
			],
        ]);

        $this->crud->addButtonFromModelFunction('line', 'contact', 'getButtonContact', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'employee', 'getButtonEmployee', 'beginning');

        // field tha use in form input / update
        $this->crud->addField(
			[
				'name' => 'name',
				'label' => "Name"
			]);
        $this->crud->addField(
			[
				'name' => 'owner_id',
				'label' => "Owner",
	            'type' => "select2_from_ajax",
	            'entity' => 'owner', 
	            'attribute' => "name", 
	            'model' => "App\Extras\Models\Customers", 
	            'data_source' => url("api/customer"), 
	            'placeholder' => "Select Owner", 
	            'minimum_input_length' => 2,
			]);
        $this->crud->addField(
			[
				'name' => 'description',
				'label' => "Description",
				'type' => 'textarea'
			]);


        $this->crud->addFilter([ // select2_ajax filter
			'name' => 'owner',
			'type' => 'select2_ajax',
			'label'=> 'Owner',
			'placeholder' => 'Pick Owner'
		],
		url('api/customer-options'), // the ajax route
		function($value) { // if the filter is active
			$this->crud->addClause('where', 'owner_id', $value);
		});

		if(! $this->request->get('owner')){
			$this->crud->addClause('where', 'owner_id', '0');
		}
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
}
