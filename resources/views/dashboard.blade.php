<x-app-layout>
    @php
        $formatCurrency = fn ($value) => 'Rp ' . number_format($value, 0, ',', '.');
    @endphp

    <div class="flex flex-col gap-10">
            <div class="flex flex-col gap-3">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Ringkasan Keuangan</p>
                <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-slate-900">Halo, {{ Auth::user()->name }} 👋</h1>
                        <p class="text-slate-500">Pantau pemasukan dan pengeluaranmu secara real-time.</p>
                    </div>
                    <span class="text-sm text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                @if (session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500">Total Pemasukan</p>
                    <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $formatCurrency($incomeTotal) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Akumulasi seluruh pemasukan</p>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500">Total Pengeluaran</p>
                    <p class="mt-2 text-2xl font-semibold text-rose-600">{{ $formatCurrency($expenseTotal) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Akumulasi seluruh pengeluaran</p>
                </div>
                <div class="rounded-2xl bg-slate-900 p-5 text-white shadow-sm">
                    <p class="text-sm text-slate-300">Saldo Bersih</p>
                    <p class="mt-3 text-3xl font-semibold">{{ $formatCurrency($balance) }}</p>
                    <p class="text-xs text-slate-400 mt-2">
                        {{ $balance >= 0 ? 'Positif' : 'Defisit' }} terhadap total cashflow
                    </p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Tren 6 Bulan Terakhir</p>
                            <h2 class="text-lg font-semibold text-slate-900">Pemasukan vs Pengeluaran</h2>
                        </div>
                    </div>
                    <div class="mt-6 h-72">
                        <canvas id="cashflow-chart" class="h-full w-full"></canvas>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100 flex flex-col gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Perbandingan</p>
                        <h3 class="text-xl font-semibold text-slate-900">{{ $balance >= 0 ? 'Keuangan Sehat' : 'Perlu Dikendalikan' }}</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-600">
                        @if (!is_null($comparisonPercent))
                            Pemasukan berada {{ $comparisonPercent >= 0 ? 'di atas' : 'di bawah' }} pengeluaran sebesar
                            <span class="font-semibold">{{ abs($comparisonPercent) }}%</span>.
                            {{ $comparisonPercent >= 0 ? 'Pertahankan kontrol pengeluaranmu agar surplus tetap terjaga.' : 'Kurangi pengeluaran atau tambah pemasukan agar angka kembali hijau.' }}
                        @else
                            Belum ada data pengeluaran sehingga rasio belum dapat dihitung.
                        @endif
                    </p>
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-600">
                        <p class="font-semibold text-slate-900">Tips cepat:</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>Catat transaksi segera setelah terjadi.</li>
                            <li>Gunakan kategori pemasukan/pengeluaran yang konsisten.</li>
                            <li>Review dashboard ini minimal seminggu sekali.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Catat Transaksi</p>
                            <h3 class="text-lg font-semibold text-slate-900">Form Input Cepat</h3>
                        </div>
                    </div>
                    <form action="{{ route('transactions.store') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label class="text-sm font-medium text-slate-600">Keterangan</label>
                            <input type="text" name="description" value="{{ old('description') }}" placeholder="Contoh: Gaji, Listrik, dll"
                                   class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <x-input-error :messages="$errors->get('description')" class="mt-1" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Jumlah</label>
                                <input type="number" name="amount" value="{{ old('amount') }}" placeholder="Rp"
                                       class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-600">Jenis</label>
                                <select name="type" class="mt-1 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="income" @selected(old('type') === 'income')>Pemasukan</option>
                                    <option value="expense" @selected(old('type') === 'expense')>Pengeluaran</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-1" />
                            </div>
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-indigo-600 py-3 text-white font-semibold shadow hover:bg-indigo-500">Simpan Transaksi</button>
                    </form>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Riwayat Terbaru</p>
                            <h3 class="text-lg font-semibold text-slate-900">8 Transaksi terakhir</h3>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        @forelse ($recentTransactions as $transaction)
                            <div class="flex items-center justify-between rounded-xl border border-slate-100 px-4 py-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $transaction->description }}</p>
                                    <p class="text-xs text-slate-400">{{ $transaction->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ $formatCurrency($transaction->amount) }}
                                    </p>
                                    <span class="text-xs inline-flex items-center rounded-full px-2 py-0.5 {{ $transaction->type === 'income' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada transaksi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('cashflow-chart');
                if (!ctx) return;

                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                label: 'Pemasukan',
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgb(16, 185, 129)',
                                borderWidth: 2,
                                data: @json($chartIncome),
                                borderRadius: 6,
                            },
                            {
                                label: 'Pengeluaran',
                                backgroundColor: 'rgba(244, 63, 94, 0.2)',
                                borderColor: 'rgb(244, 63, 94)',
                                borderWidth: 2,
                                data: @json($chartExpense),
                                borderRadius: 6,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: (value) => new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0,
                                    }).format(value),
                                },
                                grid: {
                                    color: '#f1f5f9',
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                            },
                        },
                        plugins: {
                            legend: {
                                align: 'end',
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>