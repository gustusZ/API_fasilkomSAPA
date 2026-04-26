{{-- resources/views/admin/laporan/index.blade.php --}}
{{-- Letakkan file ini di: resources/views/admin/laporan/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    LAPORAN SAPA
                </h2>
                @if ($unreadCount > 0)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    {{ $unreadCount }} baru
                </span>
                @endif
            </div>

            {{-- Tombol Export --}}
            <div class="flex gap-2">
                <a href="{{ route('laporan.export', array_merge(request()->query(), ['format' => 'csv'])) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Export CSV
                </a>
                <a href="{{ route('laporan.export', array_merge(request()->query(), ['format' => 'pdf'])) }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Flash Message --}}
            @if (session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                ✅ {{ session('success') }}
            </div>
            @endif

            {{-- ─── Form Filter & Pencarian ─────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap gap-3 items-end">

                    {{-- Pencarian --}}
                    <div class="flex-1 min-w-48">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Cari</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="No. resi, subjek, nama..."
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="min-w-44">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                        <select name="kategori"
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Kategori</option>
                            @foreach ([
                            'kinerja-dosen' => 'Kinerja Dosen',
                            'kebijakan-kampus' => 'Kebijakan Kampus',
                            'kerusakan-fasilitas' => 'Kerusakan Fasilitas',
                            'aspirasi-ormawa' => 'Aspirasi Ormawa',
                            'pengajuan-seminar' => 'Pengajuan Seminar',
                            'pelayanan-umum' => 'Pelayanan Umum',
                            ] as $key => $label)
                            <option value="{{ $key }}" {{ request('kategori') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="min-w-36">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="min-w-36">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ request('dari') }}"
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="min-w-36">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ request('sampai') }}"
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Cari
                    </button>

                    @if (request()->hasAny(['q', 'kategori', 'status', 'dari', 'sampai']))
                    <a href="{{ route('laporan.index') }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">
                        ✕ Reset
                    </a>
                    @endif
                </form>
            </div>

            {{-- ─── Tabel Laporan ───────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($laporan->isEmpty())
                <div class="py-16 text-center text-gray-400">
                    <p class="text-4xl mb-3">📭</p>
                    <p class="font-medium">Belum ada laporan</p>
                    <p class="text-sm mt-1">Laporan dari mahasiswa akan muncul di sini</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-left">
                                <th class="px-4 py-3 font-semibold text-gray-600">No. Resi</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Kategori</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Subjek</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Pelapor</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($laporan as $item)
                            <tr class="{{ !$item->is_read ? 'bg-indigo-50/40' : 'hover:bg-gray-50' }} transition">
                                {{-- Resi --}}
                                <td class="px-4 py-3 font-mono text-indigo-700 font-medium">
                                    {{ $item->tracking_id }}
                                    @if (!$item->is_read)
                                    <span class="ml-1 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                    @endif
                                </td>

                                {{-- Kategori --}}
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $item->label_kategori }}
                                </td>

                                {{-- Subjek --}}
                                <td class="px-4 py-3 text-gray-800 max-w-xs truncate">
                                    {{ $item->subjek }}
                                </td>

                                {{-- Pelapor --}}
                                <td class="px-4 py-3 text-gray-600">
                                    @if ($item->is_anonymous)
                                    <span class="text-gray-400 italic">Anonim</span>
                                    @else
                                    {{ $item->nama_pelapor ?? '-' }}
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td class="px-4 py-3">
                                    @php
                                    $statusColor = match($item->status) {
                                    'diterima' => 'bg-yellow-100 text-yellow-800',
                                    'diproses' => 'bg-blue-100 text-blue-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800',
                                    };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ $item->label_status }}
                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3">
                                    <a href="{{ route('laporan.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                                        Lihat Detail →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $laporan->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>