<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query()->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('tracking_id', 'like', "%{$keyword}%")
                    ->orWhere('subjek', 'like', "%{$keyword}%")
                    ->orWhere('nama_pelapor', 'like', "%{$keyword}%")
                    ->orWhere('isi_laporan', 'like', "%{$keyword}%");
            });
        }

        $laporan     = $query->paginate(15)->withQueryString();
        $unreadCount = Laporan::where('is_read', false)->count();

        return view('admin.laporan.index', compact('laporan', 'unreadCount'));
    }

    public function show(Laporan $laporan)
    {
        if (!$laporan->is_read) {
            $laporan->update(['is_read' => true]);
        }
        return view('admin.laporan.show', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status'   => ['required', Rule::in(['diterima', 'diproses', 'selesai'])],
            'feedback' => 'nullable|string|max:2000',
        ]);

        if (!empty($validated['feedback'])) {
            $validated['feedback_at'] = now();
        }

        $laporan->update($validated);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        $query  = Laporan::query()->latest();

        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('status'))   $query->where('status', $request->status);
        if ($request->filled('dari'))     $query->whereDate('created_at', '>=', $request->dari);
        if ($request->filled('sampai'))   $query->whereDate('created_at', '<=', $request->sampai);

        $data = $query->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.export-pdf', ['data' => $data])
                ->setPaper('a4', 'landscape');

            return $pdf->download('laporan-sapa-' . now()->format('Ymd') . '.pdf');
        }

        if ($format === 'json') {
            $export = $data->map(fn($l) => [
                'tracking_id'  => $l->tracking_id,
                'kategori'     => $l->label_kategori,
                'subjek'       => $l->subjek,
                'pelapor'      => $l->is_anonymous ? 'Anonim' : $l->nama_pelapor,
                'status'       => $l->label_status,
                'feedback'     => $l->feedback,
                'dikirim_pada' => $l->created_at->format('d/m/Y H:i'),
            ]);
            return Response::json($export)->withHeaders([
                'Content-Disposition' => 'attachment; filename="laporan-sapa.json"',
            ]);
        }

        $filename = 'laporan-sapa-' . now()->format('Ymd') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['No. Resi', 'Kategori', 'Subjek', 'Pelapor', 'Status', 'Feedback Admin', 'Tanggal Kirim']);
            foreach ($data as $l) {
                fputcsv($handle, [
                    $l->tracking_id,
                    $l->label_kategori,
                    $l->subjek,
                    $l->is_anonymous ? 'Anonim' : $l->nama_pelapor,
                    $l->label_status,
                    $l->feedback ?? '-',
                    $l->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
