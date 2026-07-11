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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->string('vehicle_no');
            $table->foreignId('supplier_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('purchase_qty', 10, 2);
            $table->decimal('purchase_amount', 10, 2);
            $table->foreignId('purchase_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('sale_price', 10, 2);
            $table->decimal('sale_qty', 10, 2);
            $table->decimal('sale_amount', 10, 2);
            $table->foreignId('sale_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->decimal('route_expense', 10, 2)->default(0);
            $table->decimal('profit_loss', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->bigInteger('refID');
            $table->timestamps();
        });

        Schema::create('order_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('accounts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment');
            $table->bigInteger('refID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_expenses');
    }
};
