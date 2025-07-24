<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Exibe a lista de categorias para organização.
     */
    public function index()
    {
        // Carrega as categorias com seus produtos, ordenadas pela posição definida
        $categories = Category::with('products')->orderBy('position', 'asc')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Mostra o formulário para criar uma nova categoria.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Salva uma nova categoria no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'required|string|max:255|unique:categories',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validatedData['image_path'] = $request->file('image_path')->store('categories', 'public');
        }

        Category::create($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Mostra o formulário para editar uma categoria.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Atualiza uma categoria no banco de dados.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $validatedData['image_path'] = $request->file('image_path')->store('categories', 'public');
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove uma categoria do banco de dados.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoria excluída com sucesso!');
    }

    /**
     * Salva a nova ordem das categorias.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:categories,id',
        ]);

        foreach ($request->ids as $index => $id) {
            Category::where('id', $id)->update(['position' => $index]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Salva a nova ordem dos produtos dentro de uma categoria.
     */
    public function reorderProducts(Request $request, Category $category)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
        ]);

        foreach ($request->ids as $index => $productId) {
            $category->products()->updateExistingPivot($productId, ['position' => $index]);
        }

        return response()->json(['status' => 'success', 'message' => 'Ordem dos produtos atualizada!']);
    }

}