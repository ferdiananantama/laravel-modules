<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('location_id')->constrained('master_locations')->onDelete('cascade');
            $table->string('shift');
            $table->decimal('work_hours', 5, 2)->nullable();
            $table->time('start_hours')->nullable();
            $table->time('breaktime1')->nullable();
            $table->time('breaktime2')->nullable();
            $table->decimal('break_duration', 5, 2)->nullable();
            $table->time('end_hours')->nullable();
            $table->integer('jumlah_user')->nullable();
            $table->integer('output')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
