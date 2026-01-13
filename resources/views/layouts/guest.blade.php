<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950">
        <div class="min-h-screen grid lg:grid-cols-2">
            <div class="relative hidden lg:flex bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 text-white">
                <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15), transparent 45%), radial-gradient(circle at 80% 0%, rgba(99,102,241,0.25), transparent 40%);"></div>
                <div class="relative z-10 flex flex-col justify-between p-12">
                    <div>
                        <div class="flex items-center gap-3">
                            <x-application-logo class="h-12 w-12 text-white" />
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-slate-300">Money</p>
                                <p class="text-2xl font-semibold">Tracker</p>
                            </div>
                        </div>
                        <p class="mt-10 text-3xl font-semibold leading-snug">Kelola keuangan lebih tenang dengan insight yang jelas.</p>
                        <p class="mt-4 text-slate-300">Dashboard minimalis, catatan transaksi super cepat, dan grafik cashflow langsung tersedia setiap saat.</p>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3">
                            <p class="text-sm text-slate-300">Pencatatan harian</p>
                            <p class="text-2xl font-semibold">+120</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 backdrop-blur px-4 py-3">
                            <p class="text-sm text-slate-300">Saldo tercatat</p>
                            <p class="text-2xl font-semibold">Rp 82 jt</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center bg-white text-slate-900 px-6 py-10 sm:px-10">
                <div class="w-full max-w-md">
                    <a href="/" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 lg:hidden">
                        <x-application-logo class="h-8 w-8 text-indigo-600" /> Money Tracker
                    </a>
                    <div class="mt-6 rounded-3xl border border-slate-100 p-8 shadow-sm">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
