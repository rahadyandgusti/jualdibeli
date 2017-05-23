<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    protected $table = 'stores';
    protected $relationship = [
        [
            'table' => 'customers',
            'id' => 'id',
            'fk' => 'owner_id',
        ],
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('logo')->nullable();
            

            /** relationship */
            foreach ($this->relationship as $value) {
                $table->unsignedInteger($value['fk']);

                $table->foreign($value['fk'])->references($value['id'])->on($value['table'])
                    ->onDelete(isset($value['delete'])?$value['delete']:'cascade')
                    ->onUpdate(isset($value['update'])?$value['update']:'cascade');
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
