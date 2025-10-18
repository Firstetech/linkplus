<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();
            $table->string('contact_form_id')->uniqid();
            $table->string('card_id');
            $table->string('user_id');
            $table->text('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('message');
            $table->string('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() 
    {
        Schema::dropIfExists('contact_forms');
    }
}
