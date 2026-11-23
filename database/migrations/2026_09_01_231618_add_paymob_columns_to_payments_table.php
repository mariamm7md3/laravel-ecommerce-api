<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('paymob_order_id')->nullable()->unique()->after('order_id');
            $table->string('payment_url')->nullable()->after('transaction_id');
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->json('gateway_response')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['paymob_order_id', 'payment_url', 'paid_at', 'gateway_response']);
        });
    }
};
