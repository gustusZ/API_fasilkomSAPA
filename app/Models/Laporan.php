<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'laporan';

    // Kolom yang boleh diisi lewat mass-assignment (misal: Laporan::create([...]))
    protected $fillable = [
        'tracking_id',
        'kategori',
        'nama_pelapor',
        'is_anonymous',
        'subjek',
        'isi_laporan',
        'target_aspirasi',
        'jurusan_dosen',
        'mata_kuliah',
        'lokasi_fasilitas',
        'nama_ormawa',
        'judul_seminar',
        'narasumber',
        'tanggal_seminar',
        'status',
        'feedback',
        'feedback_at',
        'is_read',
        'file_pendukung',
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_read'      => 'boolean',
        'tanggal_seminar' => 'date',
        'feedback_at'  => 'datetime',
    ];

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Generate tracking ID unik format SAPA-XXXX
     * Dipanggil saat membuat laporan baru.
     */
    public static function generateTrackingId(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        do {
            $random = '';
            for ($i = 0; $i < 4; $i++) {
                $random .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $id = "SAPA-{$random}";
        } while (self::where('tracking_id', $id)->exists()); // pastikan unik

        return $id;
    }

    /**
     * Label kategori yang mudah dibaca manusia.
     */
    public function getLabelKategoriAttribute(): string
    {
        return match($this->kategori) {
            'kinerja-dosen'       => 'Kinerja Dosen',
            'kebijakan-kampus'    => 'Kebijakan Kampus',
            'kerusakan-fasilitas' => 'Kerusakan Fasilitas',
            'aspirasi-ormawa'     => 'Aspirasi Ormawa',
            'pengajuan-seminar'   => 'Pengajuan Seminar',
            'pelayanan-umum'      => 'Pelayanan Umum',
            default               => $this->kategori,
        };
    }

    /**
     * Label status yang mudah dibaca.
     */
    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'diterima' => 'Diterima',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            default    => $this->status,
        };
    }
}
