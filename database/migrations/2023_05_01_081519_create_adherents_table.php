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
        Schema::create('adherents', function (Blueprint $table) {

            $table->id();
            $table->foreignId('classe_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_actif')->default(true);
            $table->string('cin')->nullable();
            $table->string('sexe');
            $table->string('profession')->nullable();
            $table->string('situation_familiale')->nullable();
            $table->date('date_of_birth');
            $table->date('date_of_membership');
            $table->string('address');
            $table->string('tel');
            $table->string('city');
            $table->string('region');
            $table->string('email')->nullable();
            $table->string('image');
            $table->date('subscription_expiry')->nullable();
            $table->string('num_adhesion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherents');
    }
};
