<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekam Medis #{{ $rekamMedis->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #ffffff;
            padding: 40px;
        }

        /* Header Klinik */
        .header {
            border-bottom: 3px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .header-title { float: left; }
        .header-title h1 { font-size: 22px; font-weight: bold; color: #064e3b; }
        .header-title p { font-size: 11px; color: #64748b; margin-top: 4px; }
        .header-meta { float: right; text-align: right; }
        .header-meta p { font-size: 11px; color: #64748b; }
        .clearfix::after { content: ''; display: table; clear: both; }

        /* Judul Dokumen */
        .doc-title { text-align: center; margin-bottom: 24px; }
        .doc-title h2 { font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; color: #064e3b; }
        .doc-title p { font-size: 11px; color: #94a3b8; margin-top: 4px; }

        /* Kartu Info */
        .info-grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-grid td { padding: 8px 12px; font-size: 11px; vertical-align: top; }
        .info-grid .label { font-weight: bold; color: #475569; width: 160px; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
        .info-grid .value { color: #1e293b; font-weight: 600; }

        /* Seksi */
        .section { margin-bottom: 20px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .section-header { background: #f8fafc; padding: 10px 16px; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #475569; border-bottom: 1px solid #e2e8f0; }
        .section-body { padding: 14px 16px; font-size: 12px; color: #334155; line-height: 1.6; }

        /* Tabel Resep */
        .resep-table { width: 100%; border-collapse: collapse; }
        .resep-table th { background: #f1f5f9; padding: 8px 12px; text-align: left; font-size: 10px; font-weight: bold; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; }
        .resep-table td { padding: 8px 12px; font-size: 11px; border-top: 1px solid #f1f5f9; color: #334155; }

        /* Tanda Tangan */
        .ttd-section { margin-top: 40px; text-align: right; }
        .ttd-box { display: inline-block; text-align: center; width: 200px; }
        .ttd-space { height: 60px; }
        .ttd-name { font-weight: bold; font-size: 12px; border-top: 1px solid #334155; padding-top: 6px; }
        .ttd-title { font-size: 10px; color: #64748b; margin-top: 2px; }

        /* Footer */
        .footer { margin-top: 30px; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #94a3b8; text-align: center; }
    </style>
</head>
<body>

    <div class="header clearfix">
        <div class="header-title">
            <h1>UniHealth Clinic</h1>
            <p>Sistem Informasi Manajemen Klinik Digital</p>
        </div>
        <div class="header-meta">
            <p>No. Rekam: <strong>#{{ $rekamMedis->id }}</strong></p>
            <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
    </div>

    <div class="doc-title">
        <h2>Rekam Medis Pasien</h2>
    </div>

    <div class="section">
        <div class="section-header">Informasi Kunjungan</div>
        <div class="section-body">
            <table class="info-grid">
                <tr>
                    <td class="label">Nama Pasien</td>
                    <td class="value">: {{ $rekamMedis->jadwal->pasien->user->nama ?? 'Pasien' }}</td>
                    <td class="label">Dokter</td>
                    <td class="value">: {{ $rekamMedis->jadwal->dokter->user->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Kunjungan</td>
                    <td class="value">: {{ \Carbon\Carbon::parse($rekamMedis->jadwal->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="label">Spesialis</td>
                    <td class="value">: {{ $rekamMedis->jadwal->dokter->spesialisasi->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Pengisian</td>
                    <td class="value" colspan="3">: {{ $rekamMedis->created_at->translatedFormat('l, d F Y') }} | Pukul {{ $rekamMedis->created_at->format('H:i') }} WIB</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-header">Keluhan</div>
        <div class="section-body">{{ $rekamMedis->keluhan }}</div>
    </div>

    <div class="section">
        <div class="section-header">Diagnosa</div>
        <div class="section-body" style="color: #065f46; font-weight: bold;">{{ $rekamMedis->diagnosa }}</div>
    </div>

    <div class="section">
        <div class="section-header">Tindakan</div>
        <div class="section-body">{{ $rekamMedis->tindakan ?? '-' }}</div>
    </div>

    @if($rekamMedis->resep->isNotEmpty())
    <div class="section">
        <div class="section-header">Resep Obat</div>
        <div class="section-body" style="padding: 0;">
            <table class="resep-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Aturan Pakai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekamMedis->resep as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->obat }}</td>
                        <td>{{ $r->dosis }}</td>
                        <td>{{ $r->aturan_pakai }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="section">
        <div class="section-header">Catatan Dokter</div>
        <div class="section-body">{{ $rekamMedis->catatan ?? '-' }}</div>
    </div>

    <div class="ttd-section">
        <div class="ttd-box">
            <div class="ttd-space"></div>
            <p class="ttd-name">{{ $rekamMedis->jadwal->dokter->user->nama ?? 'Dokter' }}</p>
            <p class="ttd-title">Dokter Pemeriksa</p>
        </div>
    </div>

    <div class="footer">
        Dokumen resmi UniHealth Clinic &bull; Dicetak pada {{ now()->translatedFormat('l, d F Y - H:i') }} WIB
    </div>

</body>
</html>