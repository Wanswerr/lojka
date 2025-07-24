<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductKey;
use Illuminate\Http\Request;

class ProductKeyController extends Controller
{
    public function index(Product $product)
    {
        $keys = $product->keys()->latest()->paginate(20);
        // Variável para ajudar a view
        $itemTypeName = $product->type === 'key' ? 'Chave' : 'Conta';
        return view('admin.products.keys.index', compact('product', 'keys', 'itemTypeName'));
    }
    
    public function store(Request $request, Product $product)
    {
        $request->validate(['keys' => 'required|string']);

        // Pega o texto do textarea e divide em linhas
        $keys = preg_split('/\\r\\n|\\r|\\n/', $request->keys);

        $count = 0;
        foreach ($keys as $key) {
            $trimmedKey = trim($key);
            if (!empty($trimmedKey)) {
                // Cria uma chave para cada linha não-vazia
                ProductKey::create([
                    'product_id' => $product->id,
                    'key_data' => $trimmedKey,
                    'status' => 'available',
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.products.keys.index', $product->id)
                     ->with('success', "$count chaves/licenças adicionadas com sucesso!");
    }

        public function destroy(ProductKey $key)
    {
        // Guardamos o ID do produto antes de excluir a chave
        $productId = $key->product_id;
        $key->delete();

        // Redirecionamos para a rota, forçando a atualização
        return redirect()->route('admin.products.keys.index', $productId)
                        ->with('success', 'Chave excluída com sucesso!');
    }

}