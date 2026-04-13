<?php $__env->startSection('title', 'Tentang Kami | UniHealth'); ?>

<?php $__env->startSection('content'); ?>
    <section class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="space-y-6">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Tentang UniHealth</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900">Klinik kampus untuk kesehatan mahasiswa dan penjadwalan dokter.</h1>
                <p class="mt-4 text-slate-600 leading-7">UniHealth adalah sistem klinik digital yang dirancang untuk komunitas universitas. Pasien dapat mendaftar, membuat janji temu untuk pemeriksaan, dan dokter dapat meninjau jadwal mendatang mereka dalam satu platform yang efisien.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl bg-sky-50 p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Pendaftaran pasien</h2>
                    <p class="mt-3 text-slate-600">Mahasiswa dapat membuat profil pasien dan menyimpan catatan klinik mereka di kampus.</p>
                </div>
                <div class="rounded-3xl bg-emerald-50 p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Penjadwalan janji temu</h2>
                    <p class="mt-3 text-slate-600">Jadwalkan pemeriksaan dengan dokter melalui alur kerja sederhana yang dibuat untuk layanan kesehatan kampus.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900">Dasbor dokter</h2>
                    <p class="mt-3 text-slate-600">Dokter dapat melihat jadwal harian mereka dan mengetahui pasien mana yang telah membuat janji konsultasi.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900">Ramah kampus</h2>
                    <p class="mt-3 text-slate-600">Dibangun untuk lingkungan universitas, UniHealth mendukung perawatan pasien yang lancar dan perencanaan janji temu.</p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/about.blade.php ENDPATH**/ ?>