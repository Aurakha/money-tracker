@php
    $primaryLinks = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => '<path d="M4 10.5 12 3l8 7.5V20a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-4H10v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z" />',
        ],
        [
            'label' => 'Profil',
            'route' => 'profile.edit',
            'icon' => '<path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5m0 2c-4 0-7 2-7 4v1h14v-1c0-2-3-4-7-4" />',
        ],
    ];
@endphp

<aside class="hidden lg:flex lg:w-72 lg:flex-col bg-white/95 backdrop-blur border-r border-slate-200 min-h-screen">
    <div class="flex flex-col h-full px-6 py-8 sticky top-0">
        <div class="flex items-center gap-3">
            <x-application-logo class="h-10 w-10 text-indigo-600" />
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Money</p>
                <p class="font-semibold text-slate-800">Tracker</p>
            </div>
        </div>

        <nav class="mt-10 space-y-2 text-sm font-medium">
            @foreach ($primaryLinks as $link)
                @php
                    $isActive = request()->routeIs($link['route']);
                @endphp
                <a href="{{ route($link['route']) }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 transition {{ $isActive ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current" stroke-width="1.5">
                        {!! $link['icon'] !!}
                    </svg>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-8 border-t border-slate-100 text-sm">
            <p class="text-slate-500">Masuk sebagai</p>
            <p class="font-semibold text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-slate-400 text-xs">{{ Auth::user()->email }}</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-slate-600 hover:border-slate-400 hover:text-slate-900 transition">Keluar</button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile navigation -->
<div x-data="{ open: false }" class="w-full lg:hidden">
    <div class="bg-white shadow-sm border-b border-slate-200">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-3">
                <x-application-logo class="h-9 w-9 text-indigo-600" />
                <span class="font-semibold text-slate-800">Money Tracker</span>
            </div>
            <button @click="open = !open" class="p-2 rounded-lg border border-slate-200 text-slate-600">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
        <div x-show="open" x-transition.origin-top.left x-cloak class="px-4 pb-4 space-y-2">
            @foreach ($primaryLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="block rounded-lg px-4 py-2 {{ request()->routeIs($link['route']) ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                @csrf
                <button type="submit" class="w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-600">Keluar</button>
            </form>
        </div>
    </div>
</div>
