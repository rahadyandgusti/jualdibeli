<?php

namespace App\Extras\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class StoreEmployees extends Model
{
	use CrudTrait;

    protected $table = 'store_employees';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function store(){
        return $this->hasOne('\App\Extras\Models\Stores','id','store_id');
    }

    public function customer(){
    	return $this->hasOne('\App\Extras\Models\Customers','id','customer_id');
    }

    public function getDescriptionEndAttribute($value){
        return $value?$value:'-';
    }

}
