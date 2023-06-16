<?php

use App\Models\Court;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id('reservation_id');
            $table->foreignId('court_id')->nullable(false)->references('court_id')->on('courts')->onDelete('restrict');
            $table->foreignId('user_id')->nullable(false)->references('user_id')->on('users')->onDelete('restrict');
            $table->boolean('doubles')->nullable(false)->default(false);
            $table->string('phone_number', 15)->nullable(false);
            $table->timestampTz('start_ts')->nullable(false);
            $table->timestampTz('end_ts')->nullable(false);
            $table->timestamps();

            $table->index('start_ts');
            $table->index('end_ts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
