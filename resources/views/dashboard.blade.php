<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin BEM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold">Selamat Datang, Admin!</h3>
                            <p class="text-sm text-gray-600">Silakan kelola data kabinet Arka Satyawira di bawah ini.</p>
                        </div>

                        <div class="mt-4 md:mt-0">
                            <a href="/admin/members" class="inline-flex items-center px-6 py-3 bg-[#2F0151] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#4a0b7a] focus:bg-[#4a0b7a] active:bg-[#1a0030] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                Kelola Anggota BEM
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</x-app-layout>