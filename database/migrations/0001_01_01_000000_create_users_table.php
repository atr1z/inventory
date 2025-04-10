<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['encargado', 'vendedor'])->default('vendedor');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('car_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_brand_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->year('year');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('auto_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name
            $table->string('brand'); // Brand
            $table->integer('quantity')->default(0); // Quantity
            $table->decimal('purchase_price', 10, 2); // Purchase price with 2 decimals
            $table->decimal('sale_price', 10, 2); // Sale price with 2 decimals (10% markup)
            $table->foreignId('car_brand_id')->constrained()->onDelete('cascade'); // Car brand (catalog)
            $table->foreignId('car_model_id')->constrained()->onDelete('cascade'); // Car model (catalog)
            $table->string('purchase_invoice')->nullable(); // Purchase invoice (PDF max 1MB)
            $table->string('provider')->nullable(); // Provider (optional)
            $table->string('image')->nullable(); // Image (max 1MB, only .png, .jpg, .jpeg)
            $table->boolean('in_stock')->default(true); // In stock flag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('auto_parts');
        Schema::dropIfExists('car_models');
        Schema::dropIfExists('car_brands');
    }
};
