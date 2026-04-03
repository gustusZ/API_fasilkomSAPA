<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Pengurus BEM') }}
            </h2>
            <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md text-xs uppercase font-bold shadow-sm hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $member->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            {{-- Jabatan --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Jabatan</label>
                                <select name="jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @php
                                        $jabatanOptions = [
                                            'Pimpinan Inti' => ['Ketua BEM', 'Wakil Ketua BEM', 'Inspektorat Jendral Internal', 'Inspektorat Jendral Proker', 'Sekretaris Umum', 'Bendahara Umum', 'Koordinator Bidang'],
                                            'Unit (Dept/Biro)' => ['Kepala Departemen', 'Wakil Kepala Departemen', 'Kepala Biro', 'Wakil Kepala Biro'],
                                            'Kepala Divisi' => ['Kepala Divisi Multimedia', 'Kepala Divisi Manajemen Publikasi', 'Kepala Divisi Internal', 'Kepala Divisi Eksternal', 'Kepala Divisi Sosial Masyarakat', 'Kepala Divisi Lingkungan Hidup', 'Kepala Divisi Kastrat', 'Kepala Divisi Adkesma', 'Kepala Divisi Keuangan', 'Kepala Divisi Kesekretariatan', 'Kepala Divisi MSDM', 'Kepala Divisi Harmonisasi'],
                                            'Staff' => ['STAFF PTI', 'STAFF AKADEMIK', 'STAFF OLAHRAGA', 'STAFF SENI BUDAYA', 'STAFF PROJECT', 'STAFF EKONOMI KREATIF', 'STAFF RELASI DIVISI INTERNAL', 'STAFF RELASI DIVISI EKSTERNAL', 'STAFF MEDKRAF DIVISI MULTIMEDIA', 'STAFF MEDKRAF DIVISI MANAJEMEN PUBLIKASI', 'STAFF SOSMASLING DIVISI SOSIAL MASYARAKAT', 'STAFF SOSMASLING DIVISI LINGKUNGAN HIDUP', 'STAFF KASTRAD DIVISI KASTRAT', 'STAFF KASTRAD DIVISI ADKESMA', 'STAFF ADMINISTRASI DIVISI KEUANGAN', 'STAFF ADMINISTRASI DIVISI KESEKRETARIATAN', 'STAFF PPSDM DIVISI MSDM', 'STAFF PPSDM DIVISI HARMONISASI']
                                        ];
                                    @endphp
                                    @foreach($jabatanOptions as $label => $options)
                                        <optgroup label="{{ $label }}">
                                            @foreach($options as $opt)
                                                <option value="{{ $opt }}" @selected(old('jabatan', $member->jabatan) == $opt)>{{ $opt }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Dept / Biro --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Departemen / Biro</label>
                                <select name="dept_biro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @php
                                        $depts = [
                                            'inti-main' => 'INTI', 'medkraf' => 'Media Kreatif', 'relasi' => 'Relasi', 'senbud' => 'Seni Budaya',
                                            'olahraga' => 'Olahraga', 'pti' => 'PTI', 'akademik' => 'Akademik', 'sosmasling' => 'Sosmasling',
                                            'kastrad' => 'Kastrad', 'project' => 'Biro Project', 'adm' => 'Biro Administrasi', 'ppsdm' => 'Biro PPSDM', 'ekraf' => 'Biro Ekonomi Kreatif'
                                        ];
                                    @endphp
                                    @foreach($depts as $key => $val)
                                        <option value="{{ $key }}" @selected(old('dept_biro', $member->dept_biro) == $key)>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Instagram --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Username Instagram</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">@</span>
                                    <input type="text" name="instagram" value="{{ old('instagram', $member->instagram) }}" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Foto Profil</label>
                                <div class="flex items-center space-x-4 mt-2 mb-2">
                                    @if($member->foto)
                                        <img src="{{ asset('storage/' . $member->foto) }}" class="h-20 w-20 object-cover rounded-lg border-2 border-indigo-100 shadow-sm">
                                    @endif
                                    <input type="file" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="text-xs text-gray-500">*Biarkan kosong jika tidak ingin mengubah foto.</p>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-md font-bold text-sm uppercase tracking-widest hover:bg-indigo-700 shadow-lg transition duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>