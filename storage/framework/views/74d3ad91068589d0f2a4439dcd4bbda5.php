<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

    <!-- Direct link to pre-compiled Vite CSS to avoid XAMPP path and CDN network issues -->
    <link rel="stylesheet" href="<?php echo e(asset('build/assets/app-T3EHGAm9.css')); ?>">
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen bg-gradient-to-b from-sky-50 via-white to-slate-100">
        <header class="border-b border-slate-200 bg-white/90 backdrop-blur-sm">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%23047f52'/%3E%3Cpath d='M32 18a10 10 0 110 20 10 10 0 010-20zm0 26c-7.18 0-13 5.82-13 13h26c0-7.18-5.82-13-13-13z' fill='%23eff6ff'/%3E%3C/svg%3E" alt="Logo" class="h-14 w-14 rounded-2xl bg-white p-2 shadow-sm">
                    <div>
                        <p class="text-sm font-semibold text-slate-500">UniHealth</p>
                        <p class="text-lg font-bold text-slate-900">Klinik Digital</p>
                    </div>
                </a>
                <nav class="flex items-center gap-4 text-sm font-medium text-slate-700">
                    <a href="<?php echo e(route('home')); ?>" class="text-slate-900 hover:text-sky-600">Beranda</a>
                    <a href="<?php echo e(route('about')); ?>" class="hover:text-sky-600">Tentang</a>
                    <a href="<?php echo e(route('contact')); ?>" class="hover:text-sky-600">Kontak</a>
                    <a href="<?php echo e(route('register')); ?>" class="rounded-full border border-emerald-600 px-4 py-2 text-emerald-600 hover:bg-emerald-50">Daftar</a>
                    <a href="<?php echo e(route('login')); ?>" class="rounded-full bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Masuk</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-10">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/layouts/app.blade.php ENDPATH**/ ?>