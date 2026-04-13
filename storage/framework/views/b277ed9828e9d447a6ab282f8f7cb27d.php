<?php $__env->startSection('title', 'UniHealth | Beranda'); ?>

<?php $__env->startSection('content'); ?>
    <section class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div class="space-y-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Sistem klinik kampus</p>
                <h1 class="text-5xl font-bold tracking-tight text-slate-900">UniHealth menghadirkan pendaftaran klinik dan penjadwalan janji temu ke kampus Anda.</h1>
                <p class="max-w-2xl text-lg leading-8 text-slate-600">Mahasiswa dapat mendaftar sebagai pasien, menjadwalkan pemeriksaan, dan dokter dapat melihat jadwal harian mereka dalam satu platform klinik digital yang bersih.</p>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-7 py-3 text-base font-semibold text-white shadow-sm hover:bg-emerald-700">Masuk</a>
                    <a href="<?php echo e(route('about')); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-7 py-3 text-base font-semibold text-slate-900 hover:bg-slate-50">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            <div class="rounded-[32px] bg-sky-50 p-8 shadow-sm border border-slate-200">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-3 rounded-full bg-white p-3 shadow-sm">
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-slate-700">Klinik digital untuk pasien dan dokter kampus</span>
                    </div>
                    <div class="space-y-4">
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Pendaftaran pasien</h2>
                            <p class="mt-2 text-slate-600">Buat profil pasien dan simpan detail kontak penting setiap mahasiswa.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Penjadwalan janji temu</h2>
                            <p class="mt-2 text-slate-600">Pesan jadwal pemeriksaan dengan cepat dan sinkronkan ketersediaan dokter.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Tampilan jadwal dokter</h2>
                            <p class="mt-2 text-slate-600">Dokter dapat meninjau janji temu pasien mereka untuk hari ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/welcome.blade.php ENDPATH**/ ?>