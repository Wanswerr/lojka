<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccessLog; // Importe o model
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function access()
    {
        // Busca os logs mais recentes, com o nome do admin junto (eager loading)
        $logs = AdminAccessLog::with('admin')->latest()->paginate(25);

        return view('admin.logs.access', compact('logs'));
    }
}