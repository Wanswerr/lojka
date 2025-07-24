<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial da loja.
     */
    public function index()
    {
        // Busca os slides ativos do carrossel, ordenados
        $slides = Carousel::where('is_active', true)->orderBy('order', 'asc')->get();

        // Busca as configurações do site
        $siteLogo = Setting::where('key', 'site_logo')->value('value');
        $footerText = Setting::where('key', 'footer_text')->value('value');

        // Busca as categorias na ordem definida e carrega os 4 primeiros produtos ativos de cada uma,
        // respeitando a ordem de produtos definida no painel.
        $categories = Category::orderBy('position', 'asc')
            ->whereHas('products', function ($query) {
                $query->where('is_active', true);
            })
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->orderBy('product_category.position', 'asc')->take(4);
            }])
            ->get();

        return view('store.home', compact('slides', 'siteLogo', 'footerText', 'categories'));
    }
}