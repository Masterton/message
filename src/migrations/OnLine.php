<?php

namespace App\Migrations;

/**
* OnLine Table Migration
* @author Masterton
* @version 1.0.0
* @time 2017-12-13 10:45:23
*
*/
class OnLine extends Base
{    
    public function up()
    {
        $this->schema->create($this->table_name, function(\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id')
                ->comment('主键ID');
            $table->string('token', 32)
                ->comment('token值');
            $table->softDeletes();
            $table->timestamps();
        });
    }
}