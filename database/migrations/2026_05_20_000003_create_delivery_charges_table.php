<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->decimal('charge', 10, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('delivery_charges')->insert([
            ['area_name' => 'Dhaka', 'charge' => 80, 'status' => true],
            ['area_name' => 'Outside Dhaka', 'charge' => 120, 'status' => true],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
