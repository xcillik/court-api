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
        Schema::create('surfaces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->id('surface_id');
            $table->decimal('rent_cost', 9, 3)->nullable(false)->default(0);
            $table->tinyText('name')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surfaces');
    }
};
