<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration (buat tabel baru).
     */
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();

            // Nomor resi unik, contoh: SAPA-A1B2
            $table->string('tracking_id', 20)->unique();

            // Kategori laporan
            $table->enum('kategori', [
                'kinerja-dosen',
                'kebijakan-kampus',
                'kerusakan-fasilitas',
                'aspirasi-ormawa',
                'pengajuan-seminar',
                'pelayanan-umum',
            ]);

            // Identitas pelapor (kosong jika anonim)
            $table->string('nama_pelapor')->nullable();
            $table->boolean('is_anonymous')->default(false);

            // Isi laporan
            $table->string('subjek');
            $table->text('isi_laporan');

            // Field opsional sesuai kategori
            $table->string('target_aspirasi')->nullable(); // nama dosen / instansi
            $table->string('jurusan_dosen')->nullable();
            $table->string('mata_kuliah')->nullable();
            $table->string('lokasi_fasilitas')->nullable();
            $table->string('nama_ormawa')->nullable();
            $table->string('judul_seminar')->nullable();
            $table->string('narasumber')->nullable();
            $table->date('tanggal_seminar')->nullable();

            // Status tindak lanjut
            $table->enum('status', [
                'diterima',   // baru masuk, belum diproses
                'diproses',   // sedang ditangani
                'selesai',    // sudah selesai
            ])->default('diterima');

            // Feedback/balasan dari admin ke pelapor
            $table->text('feedback')->nullable();
            $table->timestamp('feedback_at')->nullable();

            // Notifikasi sudah dibaca oleh admin?
            $table->boolean('is_read')->default(false);

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Batalkan migration (hapus tabel).
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
