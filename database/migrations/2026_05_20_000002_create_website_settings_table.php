<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->timestamps();
        });

        DB::table('website_settings')->insert([
            ['key' => 'website_name', 'value' => 'IMMI', 'type' => 'text'],
            ['key' => 'logo', 'value' => null, 'type' => 'image'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image'],
            ['key' => 'hero_image', 'value' => null, 'type' => 'image'],
            ['key' => 'hero_title', 'value' => 'Welcome to IMMI', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => 'Discover amazing products at great prices.', 'type' => 'text'],
            ['key' => 'footer_text', 'value' => '© 2026 IMMI. All rights reserved.', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => null, 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => null, 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => null, 'type' => 'text'],
            ['key' => 'twitter_url', 'value' => null, 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => null, 'type' => 'text'],
            ['key' => 'primary_color', 'value' => '#08a59b', 'type' => 'text'],
            ['key' => 'secondary_color', 'value' => '#0d6efd', 'type' => 'text'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
