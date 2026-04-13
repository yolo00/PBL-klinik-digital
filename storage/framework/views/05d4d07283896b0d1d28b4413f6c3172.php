<?php $__env->startSection('title', 'Hubungi Kami | UniHealth'); ?>

<?php $__env->startSection('content'); ?>
    <section class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="grid gap-10 lg:grid-cols-[1fr_1.2fr] lg:items-start">

            
            <div class="space-y-8">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Hubungi Kami</p>
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900">Kami siap membantu Anda.</h1>
                    <p class="mt-4 text-slate-600 leading-7">Apakah Anda punya pertanyaan tentang layanan klinik, janji temu, atau akun Anda? Hubungi tim kami dan kami akan segera merespons.</p>
                </div>

                <div class="space-y-5">
                    <div class="flex items-start gap-4 rounded-3xl bg-sky-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Alamat Klinik</p>
                            <p class="mt-1 text-sm text-slate-600">Gedung Kesehatan Mahasiswa Lt. 1<br>Universitas XYZ, Jl. Kampus No. 1<br>Kota, Provinsi 00000</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 rounded-3xl bg-emerald-50 p-5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Email</p>
                            <p class="mt-1 text-sm text-slate-600">klinik@kampus.ac.id</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 rounded-3xl bg-white p-5 shadow-sm border border-slate-200">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Telepon</p>
                            <p class="mt-1 text-sm text-slate-600">(021) 1234-5678</p>
                            <p class="text-xs text-slate-400 mt-1">Senin – Jumat, 08.00 – 16.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="rounded-[28px] bg-slate-50 p-8 border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900">Kirim Pesan</h2>
                <p class="mt-2 text-sm text-slate-600">Isi formulir di bawah ini dan kami akan membalas dalam 1–2 hari kerja.</p>

                <form action="#" method="POST" class="mt-6 space-y-5">
                    <?php echo csrf_field(); ?>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="contact_name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                            <input id="contact_name" name="name" type="text" placeholder="Nama Anda" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                        </div>
                        <div>
                            <label for="contact_email" class="mb-2 block text-sm font-medium text-slate-700">Alamat Email</label>
                            <input id="contact_email" name="email" type="email" placeholder="anda@kampus.ac.id" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" />
                        </div>
                    </div>

                    <div>
                        <label for="contact_subject" class="mb-2 block text-sm font-medium text-slate-700">Subjek</label>
                        <input id="contact_subject" name="subject" type="text" placeholder="Topik pesan Anda" class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                    </div>

                    <div>
                        <label for="contact_message" class="mb-2 block text-sm font-medium text-slate-700">Pesan</label>
                        <textarea id="contact_message" name="message" rows="5" placeholder="Tulis pesan Anda di sini..." class="w-full rounded-3xl border border-slate-200 bg-white px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100 resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\SEM2\PBL\PBL-klinik-digital\resources\views/contact.blade.php ENDPATH**/ ?>