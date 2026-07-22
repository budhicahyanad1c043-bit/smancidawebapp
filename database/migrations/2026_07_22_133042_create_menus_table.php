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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Nama Menu (misal: "Pengumuman", "SPP Online")
            $table->string('url')->nullable();  // URL/Path (misal: "/announcements" atau "https://...")
            $table->string('route_name')->nullable(); // Nama Route Laravel (misal: "announcements.index")
            $table->string('icon')->nullable(); // SVG atau Icon class
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade'); // Untuk Submenu/Dropdown
            $table->enum('location', ['sidebar', 'topbar', 'both'])->default('topbar'); // Lokasi Tampil
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->string('permission_role')->nullable(); // Akses role (opsional, misal: 'admin')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
