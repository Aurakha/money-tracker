<x-guest-layout>
    <div class="mb-8 space-y-2">
        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Selamat datang</p>
        <h1 class="text-2xl font-semibold text-slate-900">Masuk ke akunmu</h1>
        <p class="text-sm text-slate-500">Gunakan akun yang sudah terdaftar untuk mengakses dashboard money tracker.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="text-sm font-medium text-slate-600">Email</label>
            <input id="email" class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-medium text-slate-600">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-500 hover:text-indigo-600" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" class="mt-1 block w-full rounded-2xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" name="remember">
            Ingat saya
        </label>

        <button type="submit" class="w-full rounded-2xl bg-indigo-600 py-3 text-white font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-500">Masuk</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-slate-900 hover:text-indigo-600">Daftar sekarang</a>
    </p>
</x-guest-layout>
