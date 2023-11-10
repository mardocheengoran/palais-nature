<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable()->unique();
            $table->longText('content')->nullable();
            $table->string('type')->nullable();
            $table->double('quantity', 10, 2)->nullable();
            $table->double('price_ht', 10, 2)->nullable();
            $table->double('price_tax', 10, 2)->nullable();
            $table->double('price_delivery', 10, 2)->nullable();
            $table->double('price_discount', 10, 2)->nullable();
            $table->double('price_final', 10, 2)->nullable();
            $table->timestamp('planned_at')->nullable();
            $table->timestamp('exacted_at')->nullable();
            $table->string('ip', 255)->nullable();
            $table->boolean('status')->nullable();
            $table->foreignId('relay_id')->nullable()->constrained('articles')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('delivery_mode_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('payment_method_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('deliveryman_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('state_id')->nullable()->constrained('parameters')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('commercial_id')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('setting_id')->nullable()->constrained('settings')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null')->cascadeOnUpdate();
            $table->softDeletes()->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
