<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class SettingController extends Controller
{
    /**
     * Mostra o formulário de configurações.
     */
    public function index()
    {
        // Busca todas as configurações e as transforma em um array chave => valor
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Salva as configurações.
     */
    public function update(Request $request)
    {
        // Valida todos os campos possíveis do formulário
        $request->validate([
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'footer_text' => 'nullable|string',
            'maintenance_mode' => 'nullable',
            'google_analytics_id' => 'nullable|string',
            'facebook_pixel_id' => 'nullable|string',
        ]);

        // Pega todos os campos, exceto o token e o arquivo do logo
        $data = $request->except('_token', 'site_logo');

        // Garante que o modo de manutenção seja salvo como 0 se a caixa não estiver marcada
        $data['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;

        // Salva todas as configurações de texto
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // --- LÓGICA DE UPLOAD DO LOGO (SEPARADA E EXPLÍCITA) ---
        if ($request->hasFile('site_logo')) {
            // 1. Pega o caminho do logo antigo para apagar depois
            $oldLogoPath = Setting::where('key', 'site_logo')->value('value');

            // 2. Salva a nova imagem no disco 'public' dentro da pasta 'logos'
            $newLogoPath = $request->file('site_logo')->store('logos', 'public');

            // 3. Salva o novo caminho no banco de dados
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $newLogoPath]
            );

            // 4. Se existia um logo antigo, apaga o arquivo do servidor
            if ($oldLogoPath) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldLogoPath);
            }
        }

        // Limpa o cache para que as novas configurações sejam lidas imediatamente
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');

        return redirect()->back()->with('success', 'Configurações salvas com sucesso!');
    }
}