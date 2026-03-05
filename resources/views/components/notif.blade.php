<div x-data="{ openNotif: false }" class="relative">

    <!-- ICON BELL -->
    <button 
        @click="openNotif = !openNotif"
        class="relative text-gray-600 hover:text-blue-600 transition">

        <i class="fas fa-bell text-lg"></i>

        <!-- NOTIFICATION DOT -->
        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>

    </button>

    <!-- DROPDOWN NOTIFICATION -->
    <div 
        x-show="openNotif"
        @click.away="openNotif = false"
        x-transition
        class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-lg border p-4 z-50">

        <!-- HEADER -->
        <p class="font-semibold mb-3 text-gray-700">
            Notifikasi
        </p>

        <!-- LIST NOTIFICATION -->
        <div class="space-y-3 text-sm">

            <div class="p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                <p class="font-medium">
                    Modul Baru Tersedia
                </p>
                <p class="text-gray-500 text-xs">
                    Modul "Keselamatan Pasien" telah ditambahkan
                </p>
            </div>

            <div class="p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                <p class="font-medium">
                    Deadline Mendekat
                </p>
                <p class="text-gray-500 text-xs">
                    Modul "Manajemen Rumah Sakit" segera berakhir
                </p>
            </div>

            <div class="p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                <p class="font-medium">
                    Sertifikat Tersedia
                </p>
                <p class="text-gray-500 text-xs">
                    Sertifikat pelatihan sudah bisa diunduh
                </p>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="mt-4 text-center">
            <button class="text-blue-600 text-sm hover:underline">
                Lihat semua notifikasi
            </button>
        </div>

    </div>
</div>