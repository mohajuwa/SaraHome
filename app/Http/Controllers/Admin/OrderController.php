<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders', [
            'orders' => Order::with('user', 'items')->latest()->get(),
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,preparing,delivered,cancelled'],
        ]);

        $order->update($data);

        return back()->with('status', "تم تحديث حالة الطلب #{$order->id}.");
    }
}
