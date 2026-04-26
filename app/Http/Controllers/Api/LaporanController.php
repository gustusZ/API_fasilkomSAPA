<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

/**
 * LaporanController — endpoint API publik untuk frontend SAPA (React).
 *
 * Semua endpoint di sini TIDAK butuh login (auth publik).
 * Pengecualian: update status & feedback membutuhkan token admin via Sanctum.
 */
class LaporanController extends Controller
{
    // ─── 1. Buat Laporan Baru ─────────────────────────────────────────────────

    /**
     * POST /api/laporan
     *
     * Menerima data form dari frontend SAPA dan menyimpannya ke database.
     * Mengembalikan tracking_id yang akan ditampilkan ke mahasiswa.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kategori'        => ['required', Rule::in([
                'kinerja-dosen',
                'kebijakan-kampus',
                'kerusakan-fasilitas',
                'aspirasi-ormawa',
                'pengajuan-seminar',
                'pelayanan-umum',
            ])],
            'nama_pelapor'    => 'nullable|string|max:255',
            'is_anonymous'    => 'nullable|in:0,1,true,false',
            'subjek'          => 'required|string|max:255',
            'isi_laporan'     => 'required|string',
            'target_aspirasi' => 'nullable|string|max:255',
            'jurusan_dosen'   => 'nullable|string|max:255',
            'mata_kuliah'     => 'nullable|string|max:255',
            'lokasi_fasilitas' => 'nullable|string|max:255',
            'nama_ormawa'     => 'nullable|string|max:255',
            'judul_seminar'   => 'nullable|string|max:255',
            'narasumber'      => 'nullable|string|max:255',
            'tanggal_seminar' => 'nullable|date',
            'file_pendukung'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $validated['is_anonymous'] = filter_var($validated['is_anonymous'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($validated['is_anonymous']) {
            $validated['nama_pelapor'] = null;
        }

        // Simpan file jika ada
        // Simpan file jika ada
        if ($request->hasFile('file_pendukung')) {
            try {
                $validated['file_pendukung'] = $request->file('file_pendukung')
                    ->store('laporan', 'public');
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Gagal upload file: ' . $e->getMessage(),
                ], 500);
            }
        }

        $validated['tracking_id'] = Laporan::generateTrackingId();
        $validated['status']      = 'diterima';

        $laporan = Laporan::create($validated);

        return response()->json([
            'status'      => 'success',
            'message'     => 'Laporan berhasil dikirim!',
            'tracking_id' => $laporan->tracking_id,
        ], 201);
    }

    // ─── 2. Cek Status Laporan (Tracking) ────────────────────────────────────

    /**
     * GET /api/laporan/{tracking_id}
     *
     * Mahasiswa memasukkan kode SAPA-XXXX untuk melihat status laporannya.
     * Ini endpoint PUBLIK — siapa saja bisa cek jika tahu tracking_id.
     */
    public function show(string $trackingId): JsonResponse
    {
        $laporan = Laporan::where('tracking_id', strtoupper($trackingId))->first();

        if (!$laporan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Nomor resi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'tracking_id'   => $laporan->tracking_id,
                'kategori'      => $laporan->label_kategori,
                'subjek'        => $laporan->subjek,
                'status'        => $laporan->status,
                'label_status'  => $laporan->label_status,
                'feedback'      => $laporan->feedback,
                'feedback_at'   => $laporan->feedback_at?->format('d M Y'),
                'submitted_at'  => $laporan->created_at->format('d M Y'),
            ],
        ]);
    }
}
