<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    protected string $sessionKey = 'cart';

    public function getItems(): Collection
    {
        return collect(session($this->sessionKey . '.items', []))->map(function (array $item) {
            $item['image_url'] = $item['image'] ? '/storage/' . $item['image'] : null;
            return $item;
        });
    }

    public function count(): int
    {
        return array_sum(array_column(session($this->sessionKey . '.items', []), 'quantity'));
    }

    public function total(): float
    {
        return round((float) session($this->sessionKey . '.total', 0), 2);
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $items = session($this->sessionKey . '.items', []);

        $id = $product->id;

        if (isset($items[$id])) {
            $items[$id]['quantity'] += $quantity;
        } else {
            $items[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
                'image_url' => $product->image_url,
                'stock' => $product->stock,
            ];
        }

        session([$this->sessionKey . '.items' => $items]);
        $this->recalculate();
    }

    public function update(int $productId, int $quantity): void
    {
        $items = session($this->sessionKey . '.items', []);

        if (isset($items[$productId])) {
            $items[$productId]['quantity'] = max(1, min($quantity, $items[$productId]['stock']));
        }

        session([$this->sessionKey . '.items' => $items]);
        $this->recalculate();
    }

    public function remove(int $productId): void
    {
        $items = session($this->sessionKey . '.items', []);

        unset($items[$productId]);

        session([$this->sessionKey . '.items' => $items]);
        $this->recalculate();
    }

    public function clear(): void
    {
        session()->forget($this->sessionKey);
    }

    public static function countItems(iterable $items): int
    {
        $count = 0;
        foreach ($items as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    protected function recalculate(): void
    {
        $items = session($this->sessionKey . '.items', []);
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        session([$this->sessionKey . '.total' => round($total, 2)]);
    }
}
