<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pasien - UniHealth</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        'klinik-blue': '#3B98E8',

                        'klinik-green': '#68C96A',

                        'sidebar-dark': '#01291E',

                        'sidebar-active': '#034534',

                        'klinik-bg': '#F6F6F6',

                    },

                    fontFamily: {

                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],

                    }

                }

            }

        }

    </script>

    <style>body { font-family: 'Inter', sans-serif; }</style>

</head>

<body class="bg-klinik-bg flex min-h-screen">



    <aside class="w-64 bg-sidebar-dark flex flex-col text-white fixed h-full shadow-xl">

        <div class="p-6 flex items-center gap-3">

            <div class="w-10 h-10 bg-klinik-green rounded-xl flex items-center justify-center font-bold text-xl text-white">U</div>

            <span class="text-2xl font-bold tracking-tight">UniHealth</span>

        </div>

       

        <nav class="flex-grow px-0 mt-4">

            <div class="space-y-0">

            <a href="{{ route('pasien.dashboard') }}" class="flex items-center px-8 py-4 bg-sidebar-active border-l-4 border-klinik-green text-white font-bold">

                    <span class="text-lg mr-3"></span> Dashboard

                </a>

               

                <div class="pt-6 pb-2 px-6 flex justify-between items-center text-[11px] font-bold text-klinik-green uppercase tracking-widest opacity-80">

                    Layanan Pasien

                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>

                </div>



                <a href="{{ route('pasien.buat-janji') }}" class="flex items-center px-12 py-5 text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-5 transition text-sm">

                     Buat Janji Temu

                </a>

                <a href="#" class="flex items-center px-10 py-5 text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-5 transition text-sm">

                     Riwayat Medis

                </a>

                <a href="#" class="flex items-center px-10 py-5 text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-5 transition text-sm">

                     Pembayaran

                </a>



                <div class="mt-10 pt-6 border-t border-white border-opacity-5">

                    <a href="#" class="flex items-center px-6 py-3 text-gray-400 hover:text-red-400 transition text-sm">

                         Keluar

                    </a>

                </div>

            </div>

        </nav>

    </aside>



    <main class="ml-64 flex-grow p-8">

       

        <header class="flex justify-between items-center mb-8 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">

            <h2 class="text-xl font-bold text-gray-800">Dashboard Pasien</h2>

            <div class="flex items-center gap-4">

                <div class="text-right">

                    <p class="font-bold text-gray-800 text-sm">Aprillia Bunga</p>

                    <span class="text-[10px] bg-blue-100 text-klinik-blue px-2 py-0.5 rounded-full font-bold uppercase">Pasien</span>

                </div>

                <div class="w-10 h-10 bg-klinik-blue rounded-full flex items-center justify-center text-white font-bold">AB</div>

            </div>

        </header>



        <section class="mb-10">

            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Halo, Aprillia Bunga 👋</h1>

            <p class="text-gray-500 mb-6">Selamat datang kembali di sistem layanan Klinik Digital UniHealth.</p>

           

            <div class="bg-white p-6 rounded-2xl flex justify-between items-center shadow-sm border border-blue-50">

                <div>

                    <p class="font-semibold text-gray-800 text-lg">Butuh bantuan dokter?</p>

                    <p class="text-sm text-gray-500">Daftar jadwal konsultasi Anda di sini dengan mudah.</p>

                </div>

                <button class="bg-klinik-blue text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg shadow-blue-100">

                    Daftar Jadwal

                </button>

            </div>

        </section>



        <div class="grid grid-cols-12 gap-6">

           

            <div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">

                <div class="flex justify-between items-start mb-6">

                    <div>

                        <h2 class="text-xl font-bold text-gray-800">Ringkasan Statistik</h2>

                        <p class="text-sm text-gray-400">Catatan kunjungan terakhir Anda</p>

                    </div>

                    <span class="bg-green-100 text-klinik-green p-2 rounded-lg text-xl">📊</span>

                </div>

               

                <div class="grid grid-cols-3 gap-4">

                    <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50">

                        <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Terakhir</span>

                        <span class="font-bold text-gray-700">4 April 2026</span>

                    </div>

                    <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50 text-center">

                        <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Total</span>

                        <span class="font-bold text-3xl text-klinik-green">4</span>

                    </div>

                    <div class="bg-klinik-bg p-4 rounded-2xl border border-gray-50 text-center">

                        <span class="text-[11px] text-gray-400 block mb-1 uppercase font-bold tracking-wider">Status</span>

                        <span class="font-bold text-lg text-gray-700">Aktif</span>

                    </div>

                </div>

                <button class="mt-6 text-klinik-blue font-bold text-sm hover:underline flex items-center gap-2">

                    Lihat Rekam Medis Lengkap <span>&rarr;</span>

                </button>

            </div>



            <div class="col-span-5 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">

                <h2 class="text-xl font-bold text-gray-800 mb-1">Janji Berikutnya</h2>

                <p class="text-sm text-gray-400 mb-6">Jangan lewatkan jadwal Anda</p>

               

                <div class="bg-klinik-bg p-5 rounded-2xl border-l-4 border-klinik-blue flex items-center justify-between">

                    <div>

                        <p class="font-bold text-gray-800 text-lg">Dr. Fenni</p>

                        <p class="text-xs text-gray-500 font-medium">Spesialis Penyakit Dalam</p>

                        <div class="mt-3 flex items-center gap-2 text-klinik-blue font-bold text-xs uppercase tracking-tighter">

                            <span>📅 8 Apr 2026</span>

                            <span>⏰ 11.00 WIB</span>

                        </div>

                    </div>

                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-xl">🩺</div>

                </div>

            </div>



            <div class="col-span-7 bg-white p-7 rounded-2xl shadow-sm border border-gray-100">

                <h2 class="text-xl font-bold text-gray-800 mb-6">Menunggu Pembayaran</h2>

                <div class="flex items-center justify-between p-5 bg-klinik-bg rounded-2xl border border-blue-50">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 bg-blue-100 text-klinik-blue rounded-xl flex items-center justify-center font-bold">INV</div>

                        <div>

                            <p class="font-bold text-gray-800">Konsultasi Umum - Dr. Fenni</p>

                            <p class="text-xs text-gray-400">Tempo: 10 April 2026</p>

                        </div>

                    </div>

                    <div class="text-right">

                        <p class="font-bold text-gray-900 text-lg mb-2">Rp 50.000</p>

                        <button class="bg-klinik-green text-white px-6 py-2 rounded-xl font-bold hover:bg-green-600 transition shadow-md shadow-green-100">Bayar</button>

                    </div>

                </div>

            </div>



            <div class="col-span-5 bg-klinik-blue p-7 rounded-2xl shadow-xl text-white relative overflow-hidden">

                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>

               

                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">

                    <span>📍</span> Informasi Klinik

                </h2>

                <div class="space-y-4 relative z-10">

                    <div class="flex justify-between items-center text-sm border-b border-blue-400 border-opacity-30 pb-3">

                        <span class="opacity-80">Senin - Jumat</span>

                        <span class="font-bold">08:00 - 17:00</span>

                    </div>

                    <div class="flex justify-between items-center text-sm border-b border-blue-400 border-opacity-30 pb-3">

                        <span class="opacity-80">Sabtu</span>

                        <span class="font-bold">10:00 - 14:00</span>

                    </div>

                    <div class="mt-6">

                        <p class="text-xs opacity-80">Emergency Call:</p>

                        <p class="text-xl font-black mt-1 tracking-wider">+62 876 4894 5790</p>

                    </div>

                </div>

            </div>



        </div>

    </main>



</body>

</html>