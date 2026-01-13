<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's cashflow overview.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $incomeTotal = $user->transactions()->where('type', 'income')->sum('amount');
        $expenseTotal = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $incomeTotal - $expenseTotal;
        $comparisonPercent = $expenseTotal > 0
            ? round((($incomeTotal - $expenseTotal) / $expenseTotal) * 100, 1)
            : null;

        $recentTransactions = $user->transactions()->latest()->take(8)->get();

        $periodStart = Carbon::now()->subMonths(5)->startOfMonth();
        $months = collect(range(0, 5))->map(function ($offset) use ($periodStart) {
            $month = $periodStart->copy()->addMonths($offset)->locale(app()->getLocale());

            return [
                'key' => $month->format('Y-m'),
                'label' => $month->translatedFormat('M Y'),
            ];
        });

        $monthlyBuckets = $user->transactions()
            ->where('created_at', '>=', $periodStart)
            ->get()
            ->groupBy(fn ($transaction) => $transaction->created_at->format('Y-m'));

        $chartData = $months->map(function ($descriptor) use ($monthlyBuckets) {
            $bucket = $monthlyBuckets->get($descriptor['key'], collect());

            return [
                'label' => $descriptor['label'],
                'income' => $bucket->where('type', 'income')->sum('amount'),
                'expense' => $bucket->where('type', 'expense')->sum('amount'),
            ];
        });

        return view('dashboard', [
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'balance' => $balance,
            'comparisonPercent' => $comparisonPercent,
            'recentTransactions' => $recentTransactions,
            'chartLabels' => $chartData->pluck('label')->toArray(),
            'chartIncome' => $chartData->pluck('income')->toArray(),
            'chartExpense' => $chartData->pluck('expense')->toArray(),
        ]);
    }
}
