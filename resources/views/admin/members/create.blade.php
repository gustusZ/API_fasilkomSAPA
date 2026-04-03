<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Tambah Anggota Baru') }}
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
                    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Nama Lengkap</label>
                                <input type="text" name="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama lengkap..." required>
                            </div>

                            {{-- Jabatan --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Jabatan Spesifik</label>
                                <select name="jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                                    <optgroup label="Pimpinan Inti & Bidang">
                                        <option value="Ketua BEM">Ketua BEM</option>
                                        <option value="Wakil Ketua BEM">Wakil Ketua BEM</option>
                                        <option value="Inspektorat Jendral Internal">Inspektorat Jendral Internal</option>
                                        <option value="Inspektorat Jendral Proker">Inspektorat Jendral Proker</option>
                                        <option value="Sekretaris Umum">Sekretaris Umum</option>
                                        <option value="Bendahara Umum">Bendahara Umum</option>
                                        <option value="Koordinator Bidang">Koordinator Bidang</option>
                                    </optgroup>
                                    <optgroup label="Pimpinan Unit (Dept/Biro)">
                                        <option value="Kepala Departemen">Kepala Departemen</option>
                                        <option value="Wakil Kepala Departemen">Wakil Kepala Departemen</option>
                                        <option value="Kepala Biro">Kepala Biro</option>
                                        <option value="Wakil Kepala Biro">Wakil Kepala Biro</option>
                                    </optgroup>
                                    <optgroup label="Kepala Divisi">
                                        <option value="Kepala Divisi Multimedia">Kepala Divisi Multimedia</option>
                                        <option value="Kepala Divisi Manajemen Publikasi">Kepala Divisi Manajemen Publikasi</option>
                                        <option value="Kepala Divisi Internal">Kepala Divisi Internal</option>
                                        <option value="Kepala Divisi Eksternal">Kepala Divisi Eksternal</option>
                                        <option value="Kepala Divisi Sosial Masyarakat">Kepala Divisi Sosial Masyarakat</option>
                                        <option value="Kepala Divisi Lingkungan Hidup">Kepala Divisi Lingkungan Hidup</option>
                                        <option value="Kepala Divisi Kastrat">Kepala Divisi Kastrat</option>
                                        <option value="Kepala Divisi Adkesma">Kepala Divisi Adkesma</option>
                                        <option value="Kepala Divisi Keuangan">Kepala Divisi Keuangan</option>
                                        <option value="Kepala Divisi Kesekretariatan">Kepala Divisi Kesekretariatan</option>
                                        <option value="Kepala Divisi MSDM">Kepala Divisi MSDM</option>
                                        <option value="Kepala Divisi Harmonisasi">Kepala Divisi Harmonisasi</option>
                                    </optgroup>
                                    <optgroup label="Staff">
                                        <option value="STAFF PTI">STAFF PTI</option>
                                        <option value="STAFF AKADEMIK">STAFF AKADEMIK</option>
                                        <option value="STAFF OLAHRAGA">STAFF OLAHRAGA</option>
                                        <option value="STAFF SENI BUDAYA">STAFF SENI BUDAYA</option>
                                        <option value="STAFF PROJECT">STAFF PROJECT</option>
                                        <option value="STAFF EKONOMI KREATIF">STAFF EKONOMI KREATIF</option>
                                        <option value="STAFF RELASI DIVISI INTERNAL">STAFF RELASI DIVISI INTERNAL</option>
                                        <option value="STAFF RELASI DIVISI EKSTERNAL">STAFF RELASI DIVISI EKSTERNAL</option>
                                        <option value="STAFF MEDKRAF DIVISI MULTIMEDIA">STAFF MEDKRAF DIVISI MULTIMEDIA</option>
                                        <option value="STAFF MEDKRAF DIVISI MANAJEMEN PUBLIKASI">STAFF MEDKRAF DIVISI MANAJEMEN PUBLIKASI</option>
                                        <option value="STAFF SOSMASLING DIVISI SOSIAL MASYARAKAT">STAFF SOSMASLING DIVISI SOSIAL MASYARAKAT</option>
                                        <option value="STAFF SOSMASLING DIVISI LINGKUNGAN HIDUP">STAFF SOSMASLING DIVISI LINGKUNGAN HIDUP</option>
                                        <option value="STAFF KASTRAD DIVISI KASTRAT">STAFF KASTRAD DIVISI KASTRAT</option>
                                        <option value="STAFF KASTRAD DIVISI ADKESMA">STAFF KASTRAD DIVISI ADKESMA</option>
                                        <option value="STAFF ADMINISTRASI DIVISI KEUANGAN">STAFF ADMINISTRASI DIVISI KEUANGAN</option>
                                        <option value="STAFF ADMINISTRASI DIVISI KESEKRETARIATAN">STAFF ADMINISTRASI DIVISI KESEKRETARIATAN</option>
                                        <option value="STAFF PPSDM DIVISI MSDM">STAFF PPSDM DIVISI MSDM</option>
                                        <option value="STAFF PPSDM DIVISI HARMONISASI">STAFF PPSDM DIVISI HARMONISASI</option>
                                    </optgroup>
                                </select>
                            </div>

                            {{-- Dept / Biro --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Departemen / Biro</label>
                                <select name="dept_biro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="" disabled selected>-- Pilih Unit --</option>
                                    <option value="inti-main">INTI</option>
                                    <option value="medkraf">Media Kreatif</option>
                                    <option value="relasi">Relasi</option>
                                    <option value="senbud">Seni Budaya</option>
                                    <option value="olahraga">Olahraga</option>
                                    <option value="pti">PTI</option>
                                    <option value="akademik">Akademik</option>
                                    <option value="sosmasling">Sosmasling</option>
                                    <option value="kastrad">Kastrad</option>
                                    <option value="project">Biro Project</option>
                                    <option value="adm">Biro Administrasi</option>
                                    <option value="ppsdm">Biro PPSDM</option>
                                    <option value="ekraf">Biro Ekonomi Kreatif</option>
                                </select>
                            </div>

                            {{-- Instagram --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Instagram (Tanpa @)</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">@</span>
                                    <input type="text" name="instagram" class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="username">
                                </div>
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Foto Profil</label>
                                <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-md font-bold text-sm uppercase tracking-widest hover:bg-green-700 shadow-lg transition duration-200">
                                Simpan Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>