<?php

namespace App\Extras\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;


class Customers extends Model
{
	use CrudTrait;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    public $timestamps = true;

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
