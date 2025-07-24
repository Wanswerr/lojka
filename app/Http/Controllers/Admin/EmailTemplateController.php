<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::with('emailTemplateType')->get();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function edit(EmailTemplate $template)
    {
        return view('admin.email-templates.edit', compact('template'));
    }

     public function create()
    {
        $types = \App\Models\EmailTemplateType::all();
        return view('admin.email-templates.create', compact('types'));
    }

    /**
     * Salva um novo template no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email_template_type_id' => 'required|exists:email_template_types,id',
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
        ]);

        EmailTemplate::create($validatedData);

        return redirect()->route('admin.email-templates.index')
                         ->with('success', 'Novo template de e-mail criado com sucesso!');
    }

    /**
     * Remove um template do banco de dados.
     */
    public function destroy(EmailTemplate $template)
    {
        $template->delete();

        return redirect()->route('admin.email-templates.index')
                         ->with('success', 'Template de e-mail excluído com sucesso!');
    }

}