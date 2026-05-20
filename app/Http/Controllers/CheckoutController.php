<?php

namespace App\Http\Controllers;

use App\Mail\AdminOrderNotificationMail;
use App\Mail\OrderConfirmationMail;
use App\Models\DeliveryCharge;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function index(): View|RedirectResponse
    {
        if ($this->cart->getItems()->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['error' => 'Your cart is empty.']);
        }

        $deliveryCharges = DeliveryCharge::active()->get();

        return view('shop.checkout', [
            'items' => $this->cart->getItems(),
            'total' => $this->cart->total(),
            'deliveryCharges' => $deliveryCharges,
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        if ($this->cart->getItems()->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['error' => 'Your cart is empty.']);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string', 'max:500'],
            'customer_city' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'delivery_area' => ['nullable', 'string', 'max:255'],
            'delivery_charge' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'in:cod,card,bank_transfer'],
        ]);

        $items = $this->cart->getItems();
        $total = $this->cart->total() + (float) ($validated['delivery_charge'] ?? 0);

        try {
            $order = DB::transaction(function () use ($validated, $items, $total) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'customer_address' => $validated['customer_address'],
                    'customer_city' => $validated['customer_city'],
                    'postal_code' => $validated['postal_code'] ?? null,
                    'delivery_area' => $validated['delivery_area'] ?? null,
                    'delivery_charge' => $validated['delivery_charge'] ?? 0,
                    'total_price' => $total,
                    'status' => 'pending',
                    'shipping_address' => $validated['customer_address'],
                ]);

                foreach ($items as $item) {
                    $order->orderItems()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    Product::where('id', $item['product_id'])
                        ->decrement('stock', $item['quantity']);
                }

                $paymentMethodLabels = [
                    'cod' => 'Cash on Delivery',
                    'card' => 'Credit Card',
                    'bank_transfer' => 'Bank Transfer',
                ];

                $isCod = $validated['payment_method'] === 'cod';

                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $paymentMethodLabels[$validated['payment_method']],
                    'payment_status' => $isCod ? 'pending' : 'completed',
                    'transaction_id' => $isCod ? null : 'TXN-' . strtoupper(uniqid()),
                ]);

                $this->cart->clear();

                return $order;
            });

            try {
                Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
                Mail::to(website_setting('contact_email', 'admin@example.com'))->send(new AdminOrderNotificationMail($order));
            } catch (\Exception $e) {
                // Email sending is optional; don't block order placement
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }

        return redirect()->route('shop.confirmation', $order)
            ->with('status', 'Order placed successfully!');
    }

    public function confirmation(Order $order): View
    {
        if (auth()->check()) {
            $this->authorize('view', $order);
        }

        $order->load('orderItems.product', 'payment');

        return view('shop.confirmation', compact('order'));
    }
}
