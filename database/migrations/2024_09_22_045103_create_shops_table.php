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
        Schema::create('shops', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Shop name
            $table->string('address'); // Shop address
            $table->string('phone')->nullable(); // Optional phone number
            $table->string('email')->unique();
            $table->string('password'); // Password
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Foreign key for user (if applicable)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
