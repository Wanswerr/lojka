<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Exibe uma categoria e os produtos dentro dela para a loja.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = $category->products()
                            ->where('is_active', true)
                            ->orderBy('product_category.position', 'asc')
                            ->paginate(12);

        // Busca os dados para o layout da loja
        $siteLogo = \App\Models\Setting::where('key', 'site_logo')->value('value');
        $footerText = \App\Models\Setting::where('key', 'footer_text')->value('value');
        $allCategories = Category::orderBy('position', 'asc')->get();

        return view('store.category', compact('category', 'products', 'siteLogo', 'footerText', 'allCategories'));
    }
}