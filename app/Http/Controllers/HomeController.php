<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\JadwalSistem;
use App\Models\CutiDokter;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        return view('home', $this->getPublicData());
    }

    public function about()
    {
        return view('about', $this->getPublicData());
    }

    private function getPublicData(): array
    {
        $today = Carbon::today();

        $namaHari = match ($today->dayOfWeek) {
            Carbon::MONDAY    => 'Senin',
            Carbon::TUESDAY   => 'Selasa',
            Carbon::WEDNESDAY => 'Rabu',
            Carbon::THURSDAY  => 'Kamis',
            Carbon::FRIDAY    => 'Jumat',
            Carbon::SATURDAY  => 'Sabtu',
            default           => 'Minggu',
        };

        // Prioritas: tanggal khusus > jadwal reguler
        $jadwalHariIni =
            JadwalSistem::whereDate('tgl_khusus', $today)->first()
            ??
            JadwalSistem::where('hari', $namaHari)
                ->whereNull('tgl_khusus')
                ->first();

        $statusOperasional = 'Tutup';
        $jumlahAntrean = 0;
        $jumlahDokterTersedia = 0;

        if ($jadwalHariIni) {

            $jamSekarang = (int) now()->format('H');

            $jamBuka = $jadwalHariIni->jam_buka;
            $jamTutup = $jadwalHariIni->jam_tutup;

            $isBuka =
                !$jadwalHariIni->is_libur &&
                $jamSekarang >= $jamBuka &&
                $jamSekarang <= $jamTutup;

            $isIstirahat = false;

            if ($jadwalHariIni->jam_istirahat_mulai !== null) {

                $mulaiIstirahat = $jadwalHariIni->jam_istirahat_mulai;

                $selesaiIstirahat =
                    $jadwalHariIni->jam_istirahat_selesai
                    ?? ($mulaiIstirahat + 1);

                $isIstirahat =
                    $jamSekarang >= $mulaiIstirahat &&
                    $jamSekarang < $selesaiIstirahat;
            }

            if (!$isBuka) {
                $statusOperasional = 'Tutup';
            } elseif ($isIstirahat) {
                $statusOperasional = 'Istirahat';
            } else {
                $statusOperasional = 'Buka';
            }



            if ($statusOperasional !== 'Tutup') {

                $jumlahAntrean = Jadwal::whereDate(
                    'tanggal',
                    $today
                )->count();

                $dokterCuti = CutiDokter::where('status', 'disetujui')
                    ->whereDate('dari_tanggal', '<=', $today)
                    ->whereDate('sampai_tanggal', '>=', $today)
                    ->pluck('id_dokter');

                $jumlahDokterTersedia = Dokter::whereNotIn(
                    'id',
                    $dokterCuti
                )->count();
            }
        }
        
        return [

            'jadwalHariIni' => $jadwalHariIni,
            'statusOperasional' => $statusOperasional,
            'jumlahAntrean' => $jumlahAntrean,
            'jumlahDokterTersedia' => $jumlahDokterTersedia,
        ];

        
    }
}