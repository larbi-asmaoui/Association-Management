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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_type_id')->nullable();
            $table->string('title');
            $table->string('reference');
            $table->text('description')->nullable();
            $table->date('start');
            $table->date('end');
            $table->string('location');
            $table->string('city');
            $table->string('region');
            $table->double('revenue')->default(0);
            $table->double('depense')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
