<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Table users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role'); // Menggunakan string untuk role
            $table->timestamps();
        });

        // Table categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Table suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // Table products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('sku')->unique()->comment('Stock Keeping Unit');
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->string('image')->nullable()->comment('Path ke file gambar');
            $table->timestamps();
        });

        // Table product_attributes
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name')->comment('Misalnya: ukuran, warna, berat');
            $table->string('value');
            $table->timestamps();
        });

        // Table stock_transactions
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // Menggunakan string untuk type
            $table->integer('quantity');
            $table->date('date');
            $table->string('status'); // Menggunakan string untuk status
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        DB::statement("DROP VIEW IF EXISTS product_stock_view");
        DB::statement("
        CREATE VIEW product_stock_view AS
        SELECT p.id AS product_id,
               p.name AS product_name,
               p.sku,
               (COALESCE(SUM(CASE WHEN st.type = 'in' AND st.status = 'completed' THEN st.quantity ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN st.type = 'out' AND st.status = 'completed' THEN st.quantity ELSE 0 END), 0)) AS stock_akhir,
                MAX(st.updated_at) AS updated_at
        FROM products p
        LEFT JOIN stock_transactions st ON p.id = st.product_id
        GROUP BY p.id, p.name, p.sku;
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('stock_transactions');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');

    }
}
