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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Kolom untuk menyimpan path/lokasi file gambar
            $table->string('logo')->nullable();
            $table->string('principal_photo')->nullable();
            
            // Kolom pelengkap data instansi (sesuai form pengaturan kita)
            $table->string('school_name')->default('SMAN 1 Cidahu');
            $table->text('vision')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('welcome_message')->nullable();
            $table->text('description_school')->nullable();
            $table->string('npsn')->nullable();    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
