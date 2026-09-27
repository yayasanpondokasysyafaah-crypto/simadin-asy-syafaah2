<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard SIMADIN') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h1 class="text-3xl font-bold text-green-700">
                    SIMADIN ASY-SYAFA'AH
                </h1>

                <p class="text-gray-600 mt-2">
                    Sistem Informasi Madrasah Diniyah
                </p>

                <p class="text-sm text-gray-400 mt-2">
                    Versi 0.1
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-green-100 rounded-lg p-5">
                    <h3 class="font-bold">👳 Santri</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-blue-100 rounded-lg p-5">
                    <h3 class="font-bold">👨‍🏫 Guru</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

                <div class="bg-yellow-100 rounded-lg p-5">
                    <h3 class="font-bold">🏫 Kelas</h3>
                    <p class="text-3xl font-bold mt-2">6</p>
                </div>

                <div class="bg-purple-100 rounded-lg p-5">
                    <h3 class="font-bold">📚 Mata Pelajaran</h3>
                    <p class="text-3xl font-bold mt-2">0</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>