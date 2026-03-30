@extends('layouts.app')

@section('title', 'UniHealth | Home')

@section('content')
    <section class="rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div class="space-y-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Campus medical system</p>
                <h1 class="text-5xl font-bold tracking-tight text-slate-900">UniHealth brings clinic registration and appointment scheduling to your campus.</h1>
                <p class="max-w-2xl text-lg leading-8 text-slate-600">Students can register as patients, schedule check-ups, and doctors can view their daily schedule in one clean digital clinic platform.</p>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-7 py-3 text-base font-semibold text-white shadow-sm hover:bg-emerald-700">Login</a>
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-7 py-3 text-base font-semibold text-slate-900 hover:bg-slate-50">Learn More</a>
                </div>
            </div>

            <div class="rounded-[32px] bg-sky-50 p-8 shadow-sm border border-slate-200">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-3 rounded-full bg-white p-3 shadow-sm">
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-slate-700">Digital clinic for campus patients and doctors</span>
                    </div>
                    <div class="space-y-4">
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Patient registration</h2>
                            <p class="mt-2 text-slate-600">Create patient profiles and capture essential contact details for every student.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Appointment scheduling</h2>
                            <p class="mt-2 text-slate-600">Book check-ups quickly and keep doctor availability in sync.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <h2 class="text-lg font-semibold text-slate-900">Doctor schedule view</h2>
                            <p class="mt-2 text-slate-600">Doctors can review their patient appointments for the day.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
