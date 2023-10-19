<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string("name")->nullable();
            $table->text("objectifs")->nullable();
            $table->date("date_creation")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("region")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
