<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Manajemen Pengurus BEM') }}
            </h2>
            <a href="{{ route('members.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                + Tambah Anggota
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Pengelompokan Data --}}
            @php
                $groupedMembers = $members->groupBy('dept_biro');
                
                // Mapping ID ke Nama yang lebih rapi untuk Judul Tabel
                $deptNames = [
                    'inti-main' => 'Pimpinan Inti',
                    'medkraf'   => 'Media Kreatif',
                    'relasi'    => 'Relasi',
                    'senbud'    => 'Seni Budaya',
                    'olahraga'  => 'Olahraga',
                    'pti'       => 'PTI',
                    'akademik'  => 'Akademik',
                    'sosmasling'=> 'Sosmasling',
                    'kastrad'   => 'Kastrad',
                    'project'   => 'Biro Project',
                    'adm'       => 'Biro Administrasi',
                    'ppsdm'     => 'Biro PPSDM',
                    'ekraf'     => 'Biro Ekonomi Kreatif'
                ];
            @endphp

            @forelse($groupedMembers as $dept => $group)
                <div class="mb-10">
                    {{-- Judul Per Bidang/Biro --}}
                    <div class="flex items-center mb-4">
                        <div class="h-8 w-2 bg-indigo-600 rounded-full mr-3"></div>
                        <h3 class="text-xl font-extrabold text-gray-700 uppercase tracking-wider">
                            {{ $deptNames[$dept] ?? strtoupper($dept) }}
                        </h3>
                        <span class="ml-3 px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $group->count() }} Anggota
                        </span>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Foto</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jabatan Spesifik</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($group as $member)
                                        <tr class="hover:bg-blue-50/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($member->foto)
                                                    <img src="{{ asset('storage/' . $member->foto) }}"
                                                        class="h-12 w-12 rounded-lg border border-gray-200 object-cover shadow-sm"
                                                        alt="foto">
                                                @else
                                                    <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-[10px] text-center border border-dashed border-gray-300">
                                                        No Photo
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $member->nama }}</div>
                                                @if($member->instagram)
                                                    <div class="text-xs text-pink-600 font-medium italic">@ {{ $member->instagram }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $member->jabatan }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center items-center space-x-4">
                                                    <a href="{{ route('members.edit', $member->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 text-sm font-bold flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('members.destroy', $member->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus {{ $member->nama }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-lg shadow border border-dashed border-gray-300">
                    <p class="text-gray-500 text-lg italic">Belum ada data pengurus yang ditambahkan.</p>
                    <a href="{{ route('members.create') }}" class="mt-4 inline-block text-indigo-600 font-bold hover:underline">Tambah Anggota Sekarang &rarr;</a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>