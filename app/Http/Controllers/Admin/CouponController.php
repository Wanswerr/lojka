<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Exibe a lista de cupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Mostra o formulário para criar um novo cupom.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Salva um novo cupom no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|unique:coupons|max:255',
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        Coupon::create($validatedData);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Cupom criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um cupom.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Atualiza um cupom no banco de dados.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validatedData = $request->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('coupons')->ignore($coupon->id)],
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        $coupon->update($validatedData);

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Cupom atualizado com sucesso!');
    }

    /**
     * Remove um cupom do banco de dados.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
                         ->with('success', 'Cupom excluído com sucesso!');
    }
}