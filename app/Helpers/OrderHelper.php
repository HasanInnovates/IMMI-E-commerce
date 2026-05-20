<?php

namespace App\Helpers;

class OrderHelper
{
    public static function statusBadge(string $status): string
    {
        $map = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];

        return $map[$status] ?? 'secondary';
    }

    public static function statusLabel(string $status): string
    {
        $labels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    public static function paymentStatusBadge(string $status): string
    {
        return $status === 'completed' ? 'success' : 'warning';
    }

    public static function formatCurrency(float $amount): string
    {
        return '৳' . number_format($amount, 2);
    }
}
