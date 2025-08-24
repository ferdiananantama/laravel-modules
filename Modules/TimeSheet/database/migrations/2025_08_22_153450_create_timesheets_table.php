<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // tanggal pencatatan
            $table->time('time'); // jam (08:30, 09:30, dst.)
            $table->text('note')->nullable(); // catatan/input user
            // $table->string('created_by')->nullable(); // nik/user
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
