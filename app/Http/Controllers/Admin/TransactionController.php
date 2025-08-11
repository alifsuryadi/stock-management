<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['admin', 'transactionDetails.product'])
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::with('category')->get();
        return view('admin.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Check stock for out transactions
        if ($request->type === 'out') {
            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    return back()->withErrors([
                        'products' => "Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}"
                    ])->withInput();
                }
            }
        }

        DB::beginTransaction();

        try {
            // Create transaction
            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . date('YmdHis') . '-' . rand(1000, 9999),
                'type' => $request->type,
                'notes' => $request->notes,
                'admin_id' => Auth::guard('admin')->id(),
                'transaction_date' => $request->transaction_date,
            ]);

            // Create transaction details and update stock
            foreach ($request->products as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);

                $product = Product::find($item['product_id']);

                if ($request->type === 'in') {
                    $product->increment('stock', $item['quantity']);
                } else {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan transaksi.'
            ])->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['admin', 'transactionDetails.product.category']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $products = Product::with('category')->get();
        $transaction->load('transactionDetails');
        return view('admin.transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update([
            'notes' => $request->notes,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        DB::beginTransaction();

        try {
            // Reverse stock changes
            foreach ($transaction->transactionDetails as $detail) {
                $product = $detail->product;

                if ($transaction->type === 'in') {
                    $product->decrement('stock', $detail->quantity);
                } else {
                    $product->increment('stock', $detail->quantity);
                }
            }

            $transaction->delete();

            DB::commit();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }
}