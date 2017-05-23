<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactStoreTable extends Migration
{
    protected $table = 'store_contact';
    protected $relationship = [
        [
            'table' => 'stores',
            'id' => 'id',
            'fk' => 'store_id',
        ],
        [
            'table' => 'contacts',
            'id' => 'id',
            'fk' => 'contact_id',
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
            $table->string('value');

            /** relationship */
            foreach ($this->relationship as $value) {
                $table->unsignedInteger($value['fk']);

                $table->foreign($value['fk'])->references($value['id'])->on($value['table'])
                    ->onDelete(isset($value['delete'])?$value['delete']:'cascade')
                    ->onUpdate(isset($value['update'])?$value['update']:'cascade');
            }
            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
