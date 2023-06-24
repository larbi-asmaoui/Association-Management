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
        Schema::create('association_users', function (Blueprint $table) {
            $table->unsignedBigInteger('association_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->unique(['association_id', 'user_id']);

            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_users');
    }
};
