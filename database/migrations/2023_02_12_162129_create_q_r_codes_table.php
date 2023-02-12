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
        Schema::create('q_r_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constanted();
            $table->string('input_text')->nullable();
            $table->string('dot_color')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('dot_style')->nullable();
            $table->string('eye_style')->nullable();
            $table->string('random_code')->nullable();
            $table->string('dynamic_link')->nullable();
            $table->string('qr_type')->nullable();
            $table->string('logo_directory')->nullable();
            $table->string('logo_name')->nullable();
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
        Schema::dropIfExists('q_r_codes');
    }
};
