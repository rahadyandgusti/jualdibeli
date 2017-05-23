<?php

namespace App\Extras\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class Stores extends Model
{
	use CrudTrait;

    protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function owner(){
    	return $this->hasOne('\App\Extras\Models\Customers','id','owner_id');
    }

    public function employee(){
    	return $this->hasMany('\App\Extras\Models\StoreEmployees','store_id','id');
    }

    // public function contact(){
    // 	return $this->hasMany('\App\Extras\Models\StoreContacts','store_id','id');
    // }


    public function getId(){
    	return $this->id;
    }

    public function getButtonContact(){
    	$url = url('admin/store/'.$this->getId().'/contact');
    	return '<a class="btn btn-xs btn-default" href="'.$url.'">Contact</a>';
    }

    public function getButtonEmployee(){
    	$url = url('admin/store/'.$this->getId().'/employee');
    	return '<a class="btn btn-xs btn-default" href="'.$url.'">Employee</a>';
    }
}
