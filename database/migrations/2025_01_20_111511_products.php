<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('name_en');
            $table->string('image','1024')->nullable();
            $table->text('description_en');
            $table->string('package_insert')->nullable();
            $table->float('concentration')->nullable();           
            $table->float('price');
            $table->foreignId('category_id');
            $table->boolean('need_prescription');
            $table->Integer('amount');
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
        //
    }
};
