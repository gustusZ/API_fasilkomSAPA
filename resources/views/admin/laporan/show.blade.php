{{-- resources/views/admin/laporan/show.blade.php --}}
{{-- Letakkan file ini di: resources/views/admin/laporan/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.index') }}"
                class="text-gray-400 hover:text-gray-600 transition text-sm">
                ← Kembali
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Laporan
                <span class="font-mono text-indigo-600 ml-2">{{ $laporan->tracking_id }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Message --}}
            @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- ─── Info Laporan ──────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $laporan->subjek }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $laporan->label_kategori }} ·
                            Dikirim {{ $laporan->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    @php
                    $statusColor = match($laporan->status) {
                    'diterima' => 'bg-yellow-100 text-yellow-800',
                    'diproses' => 'bg-blue-100 text-blue-800',
                    'selesai' => 'bg-green-100 text-green-800',
                    };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                        {{ $laporan->label_status }}
                    </span>
                </div>

                {{-- Grid Info --}}
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <span class="text-gray-500">Pelapor</span>
                        <p class="font-medium text-gray-800 mt-0.5">
                            @if ($laporan->is_anonymous)
                            <span class="text-gray-400 italic">Anonim</span>
                            @else
                            {{ $laporan->nama_pelapor ?? '-' }}
                            @endif
                        </p>
                    </div>

                    @if ($laporan->target_aspirasi)
                    <div>
                        <span class="text-gray-500">Target / Ditujukan Ke</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->target_aspirasi }}</p>
                    </div>
                    @endif

                    @if ($laporan->jurusan_dosen)
                    <div>
                        <span class="text-gray-500">Jurusan Dosen</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->jurusan_dosen }}</p>
                    </div>
                    @endif

                    @if ($laporan->mata_kuliah)
                    <div>
                        <span class="text-gray-500">Mata Kuliah</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->mata_kuliah }}</p>
                    </div>
                    @endif

                    @if ($laporan->lokasi_fasilitas)
                    <div>
                        <span class="text-gray-500">Lokasi Fasilitas</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->lokasi_fasilitas }}</p>
                    </div>
                    @endif

                    @if ($laporan->nama_ormawa)
                    <div>
                        <span class="text-gray-500">Nama Ormawa</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->nama_ormawa }}</p>
                    </div>
                    @endif

                    @if ($laporan->judul_seminar)
                    <div>
                        <span class="text-gray-500">Judul Seminar</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->judul_seminar }}</p>
                    </div>
                    @endif

                    @if ($laporan->narasumber)
                    <div>
                        <span class="text-gray-500">Narasumber</span>
                        <p class="font-medium text-gray-800 mt-0.5">{{ $laporan->narasumber }}</p>
                    </div>
                    @endif

                    @if ($laporan->tanggal_seminar)
                    <div>
                        <span class="text-gray-500">Tanggal Seminar</span>
                        <p class="font-medium text-gray-800 mt-0.5">
                            {{ $laporan->tanggal_seminar->format('d M Y') }}
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Isi Laporan --}}
                <div>
                    <span class="text-sm text-gray-500">Isi Laporan</span>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-800 text-sm leading-relaxed whitespace-pre-wrap">{{ $laporan->isi_laporan }}</div>
                </div>
            </div>

            {{-- File Pendukung --}}
            @if ($laporan->file_pendukung)
            <div class="mt-4">
                <span class="text-sm text-gray-500">File Pendukung</span>
                <div class="mt-2">
                    @php
                    $ext = pathinfo($laporan->file_pendukung, PATHINFO_EXTENSION);
                    $url = Storage::url($laporan->file_pendukung);
                    @endphp

                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                    {{-- Tampilkan gambar langsung --}}
                    <a href="{{ $url }}" target="_blank">
                        <img src="{{ $url }}" alt="File Pendukung"
                            class="max-w-sm rounded-lg border border-gray-200 hover:opacity-90 transition cursor-pointer">
                    </a>
                    @else
                    {{-- Tampilkan link download untuk PDF --}}
                    <a href="{{ $url }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 transition">
                        📎 Unduh File Pendukung ({{ strtoupper($ext) }})
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- ─── Form Tindak Lanjut ────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Tindak Lanjut</h3>

                <form action="{{ route('laporan.update', $laporan) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Pilih Status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Status Laporan
                        </label>
                        <div class="flex gap-3">
                            @foreach ([
                            'diterima' => ['label' => 'Diterima', 'color' => 'yellow'],
                            'diproses' => ['label' => 'Diproses', 'color' => 'blue'],
                            'selesai' => ['label' => 'Selesai', 'color' => 'green'],
                            ] as $value => $cfg)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="{{ $value }}"
                                    {{ $laporan->status === $value ? 'checked' : '' }}
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ $cfg['label'] }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                        @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Feedback --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Feedback untuk Mahasiswa
                            <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea name="feedback" rows="4"
                            placeholder="Tuliskan tanggapan atau perkembangan tindak lanjut..."
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('feedback', $laporan->feedback) }}</textarea>
                        @error('feedback')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-400 mt-1">
                            Feedback ini akan bisa dilihat mahasiswa saat mereka cek status lewat nomor resi.
                        </p>
                    </div>

                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- ─── Riwayat Feedback (jika sudah ada) ─────────────────────── --}}
            @if ($laporan->feedback)
            <div class="bg-indigo-50 rounded-xl border border-indigo-100 p-5">
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wide mb-2">
                    Feedback Terakhir
                    @if ($laporan->feedback_at)
                    · {{ $laporan->feedback_at->format('d M Y, H:i') }}
                    @endif
                </p>
                <p class="text-sm text-indigo-900 leading-relaxed">{{ $laporan->feedback }}</p>
            </div>
            @endif

            {{-- ─── Hapus Laporan ───────────────────────────────────────────── --}}
            <div class="flex justify-end">
                <form action="{{ route('laporan.destroy', $laporan) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus laporan ini? Data tidak bisa dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition">
                        Hapus Laporan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>