<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(15);

        // --- ESTATÍSTICAS PARA OS CARDS ---

        // Total de Itens (soma de todas as chaves/contas disponíveis)
        $totalStock = Product::all()->sum('available_keys_count');

        // Valor total do estoque (soma de (preço * chaves disponíveis))
        $stockValue = Product::get()->sum(function ($product) {
            return $product->price * $product->available_keys_count;
        });
        
        // Produtos sem estoque
        $outOfStockCount = Product::get()->filter(function ($product) {
            return $product->available_keys_count == 0;
        })->count();

        // Produtos com estoque baixo (vamos definir < 5 como baixo)
        $lowStockCount = Product::get()->filter(function ($product) {
            return $product->available_keys_count > 0 && $product->available_keys_count < 5;
        })->count();

        // --- MOVIMENTAÇÕES RECENTES ---
        $recentMovements = StockMovement::with('product', 'admin')->latest()->take(10)->get();

        return view('admin.inventory.index', compact(
            'products',
            'totalStock',
            'stockValue',
            'outOfStockCount',
            'lowStockCount',
            'recentMovements'
        ));
    }

    // O método update() continua o mesmo que já tínhamos
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_change' => 'required|integer|not_in:0',
            'reason' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        DB::transaction(function () use ($request, $product) {
            $newStock = $product->stock_quantity + $request->quantity_change;
            if ($newStock < 0) {
                throw new \Exception('O estoque não pode ficar negativo.');
            }
            $product->stock_quantity = $newStock;
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'quantity_change' => $request->quantity_change,
                'reason' => 'Ajuste Manual: ' . $request->reason,
                'admin_id' => auth('admin')->id(),
            ]);
        });

        return redirect()->back()->with('success', 'Estoque do produto "' . $product->name . '" atualizado com sucesso!');
    }
}