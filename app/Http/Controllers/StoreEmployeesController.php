<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\StoreEmployeesRequest as StoreRequest;
use App\Http\Requests\StoreEmployeesRequest as UpdateRequest;

use App\Extras\Models\Stores;

class StoreEmployeesController extends CrudController
{

    public function setup() {
    	$parameter = \Route::current()->parameters();
    	$store = (new Stores)->findOrFail($parameter['idStore']);

        $this->crud->setModel("App\Extras\Models\StoreEmployees");
        $this->crud->setRoute("admin/store/".$parameter['idStore'].'/employee');
        $this->crud->setEntityNameStrings('Employee', 'Employees');

        // column in index table
        $this->crud->setColumns([
        	[
				'name' => 'store_id', 
				'label' => "Store", 
				'type' => "select",
				'entity' => 'store',
				'attribute' => "name",
				'model' => "App\Extras\Models\Stores", 
			],
        	[
				'name' => 'customer_id', 
				'label' => "Customer", 
				'type' => "select",
				'entity' => 'customer',
				'attribute' => "name",
				'model' => "App\Extras\Models\Customers", 
			],
        	[
				'name' => 'end_at', 
				'label' => "End At", 
			],
        	[
				'name' => 'description_end', 
				'label' => "Description Fired", 
			],
        ]);

        // field tha use in form input / update
        $this->crud->addField(
			[
				'name' => 'separator',
			    'type' => 'custom_html',
			    'value' => '<div class="form-group col-md-12">
							<label>Store Name : '.$store->name.'</label>
							</div>'
			]);
        $this->crud->addField(
			[
				'name' => 'customer_id',
				'label' => "Employee",
	            'type' => "select2_from_ajax",
	            'entity' => 'customer', 
	            'attribute' => "name", 
	            'model' => "App\Extras\Models\Customers", 
	            'data_source' => url("api/customer"), 
	            'placeholder' => "Select Employee", 
	            'minimum_input_length' => 2,
			]);
        $this->crud->addField(
			[
			   'name' => 'start_at',
			   'type' => 'date_picker',
			   'label' => 'Start At',
			   'date_picker_options' => [
			      'todayBtn' => 'linked',
			      'format' => 'dd-mm-yyyy',
			      'language' => 'en'
			   ],
			]);
        $this->crud->addField(
			[
				'name' => 'store_id',
				'type' => 'hidden',
				'value' => $parameter['idStore']
			]);
        $this->crud->addField(
			[
				'name' => 'description_end',
				'label' => "Description Fired",
				'type' => 'textarea'
			],'update');
        $this->crud->addField(
			[
			   'name' => 'end_at',
			   'type' => 'date_picker',
			   'label' => 'End At',
			   'date_picker_options' => [
			      'todayBtn' => 'linked',
			      'format' => 'dd-mm-yyyy',
			      'language' => 'en'
			   ],
			],'update');

        $this->crud->addButton('top', 'back', '', 
        		'<a href="'.url('admin/store?owner='.$store->owner->id.'&owner_text='.$store->owner->name).'" 
        		class="btn btn-default">Back</a>', 
        	'beginning');

        $this->crud->addFilter([ // select2_ajax filter
			'name' => 'customer',
			'type' => 'select2_ajax',
			'label'=> 'Customer',
			'placeholder' => 'Pick Customer'
		],
		url('api/customer-options'), // the ajax route
		function($value) { // if the filter is active
			$this->crud->addClause('where', 'customer_id', $value);
		});

		$this->crud->addClause('where', 'store_id', $parameter['idStore']);
    }

	public function store(StoreRequest $request)
	{
		$check = $this->crud->model->select('id')
				->where('customer_id',$request->customer_id)
				->where('store_id',$request->store_id)
				->count();

		if($check){
			\Alert::error('This User has became employee')->flash();
			return bacK()->withInput();
		} else {
			return parent::storeCrud();
		}
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
