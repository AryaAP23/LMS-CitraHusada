@extends('components.layout')
@section('title', 'pembelajaran')
@section('content')

<script>
// Check authentication on page load
document.addEventListener('DOMContentLoaded', async function() {
    try {
        const response = await axios.get('/api/check-auth');
        if (!response.data.success) {
            // User belum login, redirect ke halaman login
            window.location.href = '/';
        }
    } catch (error) {
        // Error checking auth, redirect ke login
        window.location.href = '/';
    }
});
</script>

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-md">
        {{-- Logo + Title --}}
        <div class="p-1 border-b border-grey-200">
            <div class="flex items-center gap-1 mb-6 mt-6">
            <img src="{{ asset('images/logo-lms.png') }}" alt="Logo" class="w-12 h-12">
                <div>
                    <h1 class="text-red-600 font-bold text-lg">Citra Husada</h1>
                    <p class="text-green-600 text-sm ">Learning Management System</p>
                </div>
            </div>
        </div>
        

        <nav class="p-4 space-y-2">
            <a href="" class="flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-lg">
                <i class="fa-solid fa-book"></i>
                Pembelajaran Saya
            </a>
            <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-certificate"></i>
                Sertifikat
            </a>
            <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100 rounded-lg">
                <i class="fa-solid fa-circle-user"></i>
                Profil
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200">
            <a href="#" 
            onclick="handleLogout(event)"
            class="flex items-center gap-2 text-red-600 
                    hover:text-red-800 transition duration-200">
                <i class="fa-solid fa-arrow-left"></i>
                Keluar
            </a>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-start mb-8">
            {{-- Disesuaikan siapa yang login --}}
            <div>
                <h2 class="text-2xl font-semibold">
                    Selamat Datang Kembali, Pak Agung
                </h2>
                <p class="text-sm text-gray-500">TIK Unit • Kepala Bagian</p>
            </div>
            <div class="flex items-center gap-4">
                <i class="fas fa-bell"></i>
                {{-- Sesuai siapa yang login --}}
                <div class="text-right">
                    <p class="font-medium">Agung Sunaryo</p>
                    <p class="text-sm text-gray-500">TIK Unit</p>
                </div>
            </div>
        </div>

        <!-- SEARCH -->
        <div class="mb-6">
            <div class="relative w-full max-w-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input 
                    type="text"
                    placeholder="Cari modul..."
                    class="w-full pl-10 pr-4 py-2 
                        border rounded-lg 
                        focus:outline-none 
                        focus:ring-2 focus:ring-blue-400"
                >
            </div>
        </div>

        <!-- FILTER STATUS -->
        <div class="flex w-full gap-4 mb-8">

            <a href="/belum-mulai" 
            class="flex-1 flex items-center justify-between 
                    px-6 py-3 bg-white border rounded-xl shadow-sm 
                    text-sm font-medium whitespace-nowrap 
                    hover:bg-gray-50 transition">

                <span>Belum Mulai</span>
                <i class="fa-solid fa-exclamation-circle text-gray-400"></i>
            </a>

            <a href="/materi-progress"
                class="flex-1 flex items-center justify-between 
                        px-6 py-3 bg-white border rounded-xl shadow-sm 
                        text-sm font-medium whitespace-nowrap 
                        hover:bg-gray-50 transition">

                <span>Sedang Berjalan</span>
                <i class="fa-solid fa-clock text-gray-400"></i>
            </a>

            <a href="/materi-selesai"
                class="flex-1 flex items-center justify-between 
                        px-6 py-3 bg-white border rounded-xl shadow-sm 
                        text-sm font-medium whitespace-nowrap 
                        hover:bg-gray-50 transition">

                <span>Selesai</span>
                <i class="fa-solid fa-check-circle text-gray-400"></i>
            </a>
        </div>

        <!-- CARD GRID -->
        <div class="grid md:grid-cols-3 gap-6">

            <!-- Pembelajaran progres -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="h-40 bg-gray-300 relative">
                    <span class="absolute top-3 right-3 bg-gray-800 text-white text-xs px-3 py-1 rounded-full">
                        Progres
                    </span>
                </div>

                <div class="p-5">
                    <h3 class="font-semibold text-lg">Judul</h3>
                    <p class="text-sm text-gray-500 mb-4">Sub Judul</p>

                    <div class="flex justify-between items-center text-sm mb-2">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-clock text-gray-400"></i>
                            <p>3 JPL</p>
                        </div>
                        <span class="text-red-500">
                            Due: Oct 15, 2024
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-blue-600 h-2 rounded-full w-2/3"></div>
                    </div>

                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                        Dalam Progress
                    </span>

                    <!-- BUTTON -->
                    <div class="flex gap-3 mt-5">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-caret-right"></i>
                            Lanjutkan
                        </button>
                        <button class="flex-1 border py-2 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pembelajaran selesai-->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="h-40 bg-gray-300 relative">
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-xs px-3 py-1 rounded-full">
                        Selesai
                    </span>
                </div>

                <div class="p-5">
                    <h3 class="font-semibold text-lg">Judul</h3>
                    <p class="text-sm text-gray-500 mb-4">Sub Judul</p>

                    <div class="flex justify-between items-center text-sm mb-2">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-clock text-gray-400"></i>
                            <p>3 JPL</p>
                        </div>
                        <span class="text-red-500">
                            Due: Oct 15, 2024
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-blue-500 h-2 rounded-full w-full"></div>
                    </div>

                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                        Selesai
                    </span>

                    <div class="flex gap-3 mt-5">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg">
                            <i class="fas fa-caret-right"></i>
                            Lanjutkan
                        </button>
                        <button class="flex-1 border py-2 rounded-lg">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pembelajaran belum dimulai-->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="h-40 bg-gray-300 relative">
                    <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full">
                        Belum Dimulai
                    </span>
                </div>

                <div class="p-5">
                    <h3 class="font-semibold text-lg">Judul</h3>
                    <p class="text-sm text-gray-500 mb-4">Sub Judul</p>

                    <div class="flex justify-between items-center text-sm mb-2">
                        <div class="flex items-center gap-1">
                            <i class="fa-solid fa-clock text-gray-400"></i>
                            <p>3 JPL</p>
                        </div>
                        <span class="text-red-500">
                            Due: Oct 15, 2024
                        </span>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="bg-blue-500 h-2 rounded-full w-0"></div>
                    </div>

                    <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-full">
                        Belum Dimulai
                    </span>

                    <div class="flex gap-3 mt-5">
                        <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg">
                            <i class="fas fa-caret-right"></i>
                            Lanjutkan
                        </button>
                        <button class="flex-1 border py-2 rounded-lg">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- LOAD MORE -->
        <div class="text-center mt-10">
            <button class="text-blue-600 hover:underline">
                Lihat Lebih Banyak →
            </button>
        </div>

    </main>
</div>

<script>
async function handleLogout(event) {
    event.preventDefault();

    if (!confirm('Apakah Anda yakin ingin keluar?')) {
        return;
    }

    try {
        const response = await axios.post('/api/logout');

        if (response.data.success) {
            window.location.href = '/';
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        console.error('Logout error:', error);
        // Fallback ke redirect langsung jika ada error
        window.location.href = '/';
    }
}
</script>

@endsection