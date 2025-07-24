<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Label;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pega todos os valores dos filtros da URL
        $search = $request->query('search');
        $categoryFilter = $request->query('category');
        $statusFilter = $request->query('status');

        // Começa a query base
        $query = Product::with('categories');

        // Aplica o filtro de pesquisa de texto
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Aplica o filtro de categoria
        if ($categoryFilter) {
            $query->whereHas('categories', function ($q) use ($categoryFilter) {
                $q->where('categories.id', $categoryFilter);
            });
        }
        
        // Aplica o filtro de status (que é uma condição mais complexa)
        if ($statusFilter) {
            if ($statusFilter == 'active') {
                $query->where('is_active', true);
            } elseif ($statusFilter == 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(15);
        
        // Busca todas as categorias para popular o menu do filtro
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'categoryFilter', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $labels = Label::all();

        // --- LÓGICA ADICIONADA ---
        $deliveryEmailType = EmailTemplateType::where('type_key', 'product_delivery')->first();
        $deliveryTemplates = $deliveryEmailType ? $deliveryEmailType->emailTemplates : collect();
        // --- FIM DA LÓGICA ADICIONADA ---

        return view('admin.products.create', compact('categories', 'tags', 'labels', 'deliveryTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validação dos dados
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:products',
        'slug' => 'required|string|max:255|unique:products',
        'type' => 'required|in:key,account', // <-- ADICIONE ESTA VALIDAÇÃO
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'is_active' => 'required|boolean',
        'categories' => 'nullable|array',
        'categories.*' => 'exists:categories,id',
        'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'email_template_id' => 'nullable|exists:email_templates,id' // Validação que já tínhamos
    ]);

        if ($request->hasFile('image_path')) {
        $validatedData['image_path'] = $request->file('image_path')->store('products', 'public');
    }

    // 2. Cria o produto principal
    $product = Product::create($validatedData); // Agora $validatedData já inclui o 'type'

    // 3. Associa as categorias ao produto
    if (!empty($validatedData['categories'])) {
        $product->categories()->sync($validatedData['categories']);
    }

        // Repita o processo para tags e labels aqui...

        // 4. Redireciona com mensagem de sucesso
        return redirect()->route('admin.products.index')
                        ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $labels = Label::all();

        // --- LÓGICA ADICIONADA ---
        $deliveryEmailType = EmailTemplateType::where('type_key', 'product_delivery')->first();
        $deliveryTemplates = $deliveryEmailType ? $deliveryEmailType->emailTemplates : collect();
        // --- FIM DA LÓGICA ADICIONADA ---

        return view('admin.products.edit', compact('product', 'categories', 'tags', 'labels', 'deliveryTemplates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validação
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'type' => 'required|in:key,account', // <-- ADICIONE ESTA VALIDAÇÃO
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'email_template_id' => 'nullable|exists:email_templates,id'
        ]);

        if ($request->hasFile('image_path')) {
        // Apaga a imagem antiga para não acumular lixo
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $validatedData['image_path'] = $request->file('image_path')->store('products', 'public');
        }

        // 2. Atualiza os campos principais do produto
        $product->update($validatedData); // Agora $validatedData já inclui o 'type'

        // 3. Sincroniza as categorias
        $product->categories()->sync($request->categories ?? []);

        // ... (resto do código)

        return redirect()->route('admin.products.index')
                        ->with('success', 'Produto atualizado com sucesso!');
    }

/**
     * Remove o recurso do banco de dados.
     */
    public function destroy(Product $product)
    {
        // O model binding já encontra o produto para nós
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produto excluído com sucesso!');
    }
}
