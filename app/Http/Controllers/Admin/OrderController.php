<?php
namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\Order; // Importe o Model
use App\Models\Admin;
use App\Notifications\NewOrderPaid;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Exibe a lista de pedidos.
     */
 public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Order::with('user', 'items');

        if ($search) {
            $query->where(function($q) use ($search) {
                // Pesquisa pelo ID do pedido
                $q->where('id', 'LIKE', "%{$search}%")
                  // Ou pesquisa pelo nome ou email do cliente (através do relacionamento)
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        $orders = $query->latest()->paginate(15);
        
        $pendingCount = Order::where('status', 'pending')->count();
        $paidCount = Order::where('status', 'paid')->count();

        return view('admin.orders.index', compact('orders', 'pendingCount', 'paidCount', 'search'));
    }

    public function show(Order $order)
        {
        // Carrega o pedido com todos os relacionamentos necessários de uma vez
        $order->load('user', 'items.product', 'items.deliveredKey');

        return view('admin.orders.show', compact('order'));
        }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,paid,shipped,delivered,canceled',
        ]);

        $order->status = $request->status;
        $order->save();

    if ($request->status == 'paid') {
        // Encontra o Super Admin
        $admin = Admin::find(1);
        // Notifica ele usando o novo sistema
        if ($admin) {
            $admin->notify(new NewOrderPaid($order));
        }
    }

        return redirect()->route('admin.orders.show', $order->id)
                         ->with('success', 'Status do pedido atualizado com sucesso!');
    }   
}