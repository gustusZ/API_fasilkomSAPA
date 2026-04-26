<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 4px; color: #2F0151; }
        p.sub { text-align: center; color: #888; margin-bottom: 16px; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2F0151; color: white; padding: 6px 8px; text-align: left; }
        td { padding: 5px 8px; border-bottom: 1px solid #eee; }
        tr:nth-child(even) td { background: #f9f9f9; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .diterima { background: #fef9c3; color: #854d0e; }
        .diproses { background: #dbeafe; color: #1e40af; }
        .selesai  { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <h2>Laporan SAPA — BEM Fasilkom UNSRI</h2>
    <p class="sub">Dicetak pada {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No. Resi</th>
                <th>Kategori</th>
                <th>Subjek</th>
                <th>Pelapor</th>
                <th>Status</th>
                <th>Tanggal Kirim</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $l)
            <tr>
                <td>{{ $l->tracking_id }}</td>
                <td>{{ $l->label_kategori }}</td>
                <td>{{ $l->subjek }}</td>
                <td>{{ $l->is_anonymous ? 'Anonim' : $l->nama_pelapor }}</td>
                <td><span class="badge {{ $l->status }}">{{ $l->label_status }}</span></td>
                <td>{{ $l->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>