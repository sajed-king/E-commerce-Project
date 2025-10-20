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
        Schema::create('coupons', function (Blueprint $table) {
            

          $table->id();  
          $table->string('code')->unique();  
          $table->enum('type', ['fixed', 'percent']);  
          $table->decimal('value', 8, 2);  
          $table->decimal('min_order', 8, 2)->nullable();  
          $table->dateTime('valid_from');  
          $table->dateTime('valid_to');  
          $table->integer('usage_limit')->nullable();  
          $table->integer('per_user_limit')->nullable();  
          $table->boolean('is_active')->default(true);  
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
        Schema::dropIfExists('coupons');
    }
};
