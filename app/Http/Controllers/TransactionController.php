<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
        ]);

        $request->user()->transactions()->create($validated);

        return back()->with('success', 'Transaksi berhasil dicatat!');
    }
}
