<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCharge;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeliveryChargeController extends Controller
{
    public function index(): View
    {
        $charges = DeliveryCharge::latest()->paginate(15);

        return view('admin.delivery-charges.index', compact('charges'));
    }

    public function create(): View
    {
        return view('admin.delivery-charges.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'area_name' => ['required', 'string', 'max:255'],
            'charge' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        DeliveryCharge::create($validated);

        return redirect()->route('admin.delivery-charges.index')
            ->with('status', 'Delivery charge created successfully.');
    }

    public function edit(DeliveryCharge $deliveryCharge): View
    {
        return view('admin.delivery-charges.edit', [
            'charge' => $deliveryCharge,
        ]);
    }

    public function update(Request $request, DeliveryCharge $deliveryCharge): RedirectResponse
    {
        $validated = $request->validate([
            'area_name' => ['required', 'string', 'max:255'],
            'charge' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status');

        $deliveryCharge->update($validated);

        return redirect()->route('admin.delivery-charges.index')
            ->with('status', 'Delivery charge updated successfully.');
    }

    public function destroy(DeliveryCharge $deliveryCharge): RedirectResponse
    {
        $deliveryCharge->delete();

        return redirect()->route('admin.delivery-charges.index')
            ->with('status', 'Delivery charge deleted successfully.');
    }
}
