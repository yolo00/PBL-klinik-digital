@extends('layouts.app')

@section('title', 'Login | UniHealth')

@section('content')
    <section class="mx-auto max-w-md rounded-[32px] border border-slate-200 bg-white p-8 shadow-sm">
        <div class="space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-600">Welcome back</p>
                <h1 class="mt-3 text-3xl font-bold text-slate-900">Sign in to UniHealth</h1>
                <p class="mt-3 text-slate-600">Access your clinic schedule and patient appointments on campus.</p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email address</label>
                    <input id="email" name="email" type="email" placeholder="you@campus.edu" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-100" />
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter your password" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-100" />
                </div>

                <button type="submit" class="w-full rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Login</button>
            </form>

            <p class="text-center text-sm text-slate-500">Need an account? Ask your campus admin to register you.</p>
        </div>
    </section>
@endsection
