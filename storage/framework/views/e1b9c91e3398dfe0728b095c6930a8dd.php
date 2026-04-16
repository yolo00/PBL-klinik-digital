<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniHealth - Dashboard Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <div class="w-64 bg-white border-r">
            <div class="p-6 border-b flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-300 border border-black"></div>
                <span class="text-xl font-bold">UniHealth</span>
            </div>
            <nav class="mt-4">
                <a href="#" class="block px-6 py-3 bg-gray-200 font-semibold border-l-4 border-gray-500">Dashboard</a>
                <a href="#" class="block px-6 py-3 text-gray-600 hover:bg-gray-100">Jadwal Saya</a>
                <a href="#" class="block px-6 py-3 text-gray-600 hover:bg-gray-100">Pengaturan Jadwal</a>
                <a href="#" class="block px-6 py-3 text-gray-600 hover:bg-gray-100">Pasien</a>
                <a href="#" class="block px-6 py-3 text-gray-600 hover:bg-gray-100">Rekam Medis</a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <div class="flex justify-end mb-8">
                <div class="flex items-center gap-3 bg-white p-2 rounded-lg shadow-sm border">
                    <div class="text-right">
                        <p class="text-sm font-bold">Dr. Fenni 👋</p>
                        <p class="text-xs text-gray-500">Dokter</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center border">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>
                </div>
            </div>

            <h1 class="text-2xl font-bold mb-6">Selamat datang, Dr. Fenni 👋</h1>

            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-200 p-6 rounded-2xl shadow-sm border border-gray-300">
                    <p class="text-sm font-semibold mb-2">Jadwal hari ini</p>
                    <p class="text-lg">1 Jadwal</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-2xl shadow-sm border border-gray-300">
                    <p class="text-sm font-semibold mb-2">Semua Jadwal Mendatang</p>
                    <p class="text-lg">2 Jadwal</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-2xl shadow-sm border border-gray-300">
                    <p class="text-sm font-semibold mb-2">Rekam Belum Terisi</p>
                    <p class="text-lg">1 Rekam</p>
                </div>
                <div class="bg-gray-200 p-6 rounded-2xl shadow-sm border border-gray-300">
                    <p class="text-sm font-semibold mb-2">Status anda hari ini</p>
                    <p class="text-lg text-green-600 font-bold">Aktif</p>
                </div>
            </div>

            <div class="bg-gray-200 rounded-2xl p-6 mb-8 border border-gray-300">
                <h2 class="text-sm font-bold mb-4">Jadwal hari ini:</h2>
                <table class="w-full text-left">
                    <thead class="border-b border-gray-400 text-sm">
                        <tr>
                            <th class="pb-2">Nama</th>
                            <th class="pb-2">Jam</th>
                            <th class="pb-2">Status</th>
                            <th class="pb-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="bg-white rounded-lg shadow-sm">
                            <td class="py-3 px-2 rounded-l-lg">Budi</td>
                            <td class="py-3 px-2">11.00</td>
                            <td class="py-3 px-2">Mendatang</td>
                            <td class="py-3 px-2 rounded-r-lg">
                                <button class="bg-gray-400 text-white px-4 py-1 rounded-full text-xs hover:bg-gray-500">mulai</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-2xl p-8 border border-gray-300 shadow-sm flex gap-10">
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-4">
                        <button class="text-gray-400">&lt;</button>
                        <h3 class="font-bold">April 2026</h3>
                        <button class="text-gray-400">&gt;</button>
                    </div>
                    <div class="grid grid-cols-7 gap-4 text-center text-sm">
                        <span class="text-gray-300">30</span><span class="text-gray-300">31</span>
                        <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                        <span>6</span><span>7</span><span class="underline font-bold">8</span><span>9</span><span>10</span><span>11</span><span>12</span>
                        <span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span><span>19</span>
                    </div>
                </div>
                <div class="w-64 border-l pl-8">
                    <h4 class="text-xs font-bold mb-2">Informasi :</h4>
                    <p class="text-xs text-gray-500 mb-4">* Klinik libur atau cuti</p>
                    <p class="text-xs text-gray-600 underline mb-6">Garis bawah menandakan hari ini</p>
                    <p class="text-xs font-semibold">24 April - 25 April anda mengajukan cuti</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\PBL-klinik-digital\resources\views/dashboard_dokter.blade.php ENDPATH**/ ?>