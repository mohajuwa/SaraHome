<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function add(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        $request->session()->put('cart', $cart);

        return back()->with('status', "أُضيفت «{$product->name}» إلى السلة 🛒");
    }

    public function index(Request $request): View
    {
        [$items, $total] = $this->hydrate($request);

        return view('client.cart', ['items' => $items, 'total' => $total]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'qty' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $cart = $request->session()->get('cart', []);

        if ($data['qty'] === 0) {
            unset($cart[$data['product_id']]);
        } else {
            $cart[$data['product_id']] = $data['qty'];
        }

        $request->session()->put('cart', $cart);

        return back();
    }

    public function checkout(Request $request): RedirectResponse
    {
        $data = $request->validate(['note' => ['nullable', 'string', 'max:500']]);
        [$items, $total] = $this->hydrate($request);

        if ($items->isEmpty()) {
            return redirect()->route('client.store')->with('status', 'سلتك فارغة — تصفّحي المتجر أولاً.');
        }

        DB::transaction(function () use ($request, $items, $total, $data) {
            $order = $request->user()->orders()->create([
                'status' => 'new',
                'total' => $total,
                'note' => $data['note'] ?? null,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'name' => $item['product']->name,
                    'price' => $item['product']->price,
                    'qty' => $item['qty'],
                ]);
            }
        });

        $request->session()->forget('cart');

        return redirect()->route('client.orders')->with('status', 'تم إرسال طلبك بنجاح 🌿 سنتواصل معك قريباً.');
    }

    public function orders(Request $request): View
    {
        return view('client.orders', [
            'orders' => $request->user()->orders()->with('items')->latest()->get(),
        ]);
    }

    /** @return array{0: \Illuminate\Support\Collection, 1: int} */
    protected function hydrate(Request $request): array
    {
        $cart = $request->session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)
            ->map(fn ($qty, $id) => isset($products[$id]) ? ['product' => $products[$id], 'qty' => (int) $qty] : null)
            ->filter()
            ->values();

        $total = $items->sum(fn ($i) => $i['product']->price * $i['qty']);

        return [$items, $total];
    }
}
