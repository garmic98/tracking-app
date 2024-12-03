<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('request_data', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('operating_system')->nullable();
            $table->string('device')->nullable();
            $table->string('referrer')->nullable();
            $table->string('url');
            $table->string('language')->nullable();
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_data');
    }
};
