<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Importante para manipulação de arquivos

class CarouselController extends Controller
{
    public function index()
    {
        $slides = Carousel::orderBy('order', 'asc')->get();
        return view('admin.carousels.index', compact('slides'));
    }

    /**
     * Mostra o formulário para criar um novo slide.
     */
    public function create()
    {
        return view('admin.carousels.create');
    }

    /**
     * Salva o novo slide no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_url' => 'nullable|url',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        // Salva a imagem e pega o caminho
        $validatedData['image_path'] = $request->file('image_path')->store('carousels', 'public');

        Carousel::create($validatedData);

        return redirect()->route('admin.carousels.index')
                         ->with('success', 'Slide criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um slide.
     */
    public function edit(Carousel $carousel)
    {
        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Atualiza o slide no banco de dados.
     */
    public function update(Request $request, Carousel $carousel)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // Imagem é opcional na edição
            'link_url' => 'nullable|url',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        // Se uma nova imagem for enviada...
        if ($request->hasFile('image_path')) {
            // 1. Apaga a imagem antiga
            Storage::disk('public')->delete($carousel->image_path);
            // 2. Salva a nova imagem
            $validatedData['image_path'] = $request->file('image_path')->store('carousels', 'public');
        }

        $carousel->update($validatedData);

        return redirect()->route('admin.carousels.index')
                         ->with('success', 'Slide atualizado com sucesso!');
    }

    /**
     * Remove o slide do banco de dados.
     */
    public function destroy(Carousel $carousel)
    {
        // Apaga a imagem do armazenamento
        Storage::disk('public')->delete($carousel->image_path);
        
        // Apaga o registro do banco
        $carousel->delete();

        return redirect()->route('admin.carousels.index')
                         ->with('success', 'Slide excluído com sucesso!');
    }
}