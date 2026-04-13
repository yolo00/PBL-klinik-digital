<?php $__env->startSection('title', 'Masuk | UniHealth'); ?>

<?php $__env->startSection('content'); ?>
    <section class="mx-auto max-w-md rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Selamat datang kembali</p>
                <h1 class="mt-3 text-3xl font-bold text-slate-900">Masuk ke UniHealth</h1>
                <p class="mt-3 text-slate-600">Akses jadwal klinik dan janji temu pasien Anda di kampus.</p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email</label>
                    <input id="email" name="email" type="email" placeholder="anda@kampus.ac.id" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" />
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Kata Sandi</label>
                    <input id="password" name="password" type="password" placeholder="Masukkan kata sandi Anda" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                </div>

                <button type="submit" class="w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Masuk</button>
            </form>

            <div class="space-y-2 text-center">
                <p class="text-sm text-slate-500">
                    Belum punya akun?
                    <a href="<?php echo e(route('register')); ?>" class="font-semibold text-emerald-600 hover:text-emerald-700">Daftar sekarang</a>
                </p>
                <p class="text-sm text-slate-500">
                    Punya pertanyaan?
                    <a href="<?php echo e(route('contact')); ?>" class="font-semibold text-sky-600 hover:text-sky-700">Hubungi kami</a>
                </p>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/login.blade.php ENDPATH**/ ?>