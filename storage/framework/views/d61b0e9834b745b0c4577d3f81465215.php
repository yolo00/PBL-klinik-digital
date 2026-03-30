

<?php $__env->startSection('title', 'About UniHealth'); ?>

<?php $__env->startSection('content'); ?>
    <section class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="space-y-6">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">About UniHealth</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-900">A campus clinic for student health and doctor scheduling.</h1>
                <p class="mt-4 text-slate-600 leading-7">UniHealth is a digital clinic system designed for university communities. Patients can register, book appointments for check-ups, and doctors can review their upcoming schedules in one streamlined platform.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl bg-sky-50 p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Patient registration</h2>
                    <p class="mt-3 text-slate-600">Students can create a patient profile and keep their clinic records organized on campus.</p>
                </div>
                <div class="rounded-3xl bg-emerald-50 p-6">
                    <h2 class="text-xl font-semibold text-slate-900">Appointment scheduling</h2>
                    <p class="mt-3 text-slate-600">Schedule check-ups with doctors in a simple workflow built for campus health services.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900">Doctor dashboard</h2>
                    <p class="mt-3 text-slate-600">Doctors can view their daily schedule and see which patients are booked for consultations.</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <h2 class="text-xl font-semibold text-slate-900">Campus friendly</h2>
                    <p class="mt-3 text-slate-600">Built for the university environment, UniHealth supports seamless patient care and appointment planning.</p>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\KlinikDigital\resources\views/about.blade.php ENDPATH**/ ?>