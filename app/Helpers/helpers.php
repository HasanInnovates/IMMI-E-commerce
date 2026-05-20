<?php

if (!function_exists('format_currency')) {
    function format_currency(float $amount): string
    {
        return \App\Helpers\OrderHelper::formatCurrency($amount);
    }
}

if (!function_exists('website_setting')) {
    function website_setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\WebsiteSetting::getValue($key, $default);
    }
}

if (!function_exists('website_setting_image')) {
    function website_setting_image(string $key): ?string
    {
        return \App\Models\WebsiteSetting::getImageUrl($key);
    }
}
