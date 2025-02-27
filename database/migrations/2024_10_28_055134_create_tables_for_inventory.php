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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(false);
            $table->string('role')->nullable(); // Menggunakan string untuk role
            $table->timestamps();
            $table->index(['id']);
        });

        // Table categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['id']);
        });

        // Table suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->index(['id']);
        });

        // Table products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('sku')->unique()->comment('Stock Keeping Unit');
            $table->integer('minimal_stock')->default(0);
            $table->text('description')->nullable();
            $table->integer('purchase_price');
            $table->integer('selling_price');
            $table->string('image')->nullable()->comment('Path ke file gambar');
            $table->timestamps();
            $table->index(['id']);
        });

        // Table product_attributes
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name')->comment('Misalnya: ukuran, warna, berat');
            $table->string('value');
            $table->timestamps();
            $table->index(['id']);
        });

        Schema::create('product_stock', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->primary();
            $table->integer('stock')->default(0);
            $table->integer('minimal_stock')->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index(['product_id']);
        });

        // Table stock_transactions
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('type'); // Menggunakan string untuk type
            $table->integer('quantity');
            $table->date('date');
            $table->string('status'); // Menggunakan string untuk status
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'type','id']);
        });
        
        // Table riwayat_opname
        Schema::create('riwayat_opname', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('token');
            $table->date('tanggal_opname');  // Menghapus spasi ekstra
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();  // Untuk mencatat waktu pembuatan dan pembaruan
            $table->index('id');
        });
        
        // Tabel detail_opname
        Schema::create('detail_opname', function (Blueprint $table) {
            $table->id();
            $table->uuid('riwayat_opname_id');
            $table->foreign('riwayat_opname_id')->references('id')->on('riwayat_opname')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('stok_fisik');
            $table->integer('stok_sistem');
            $table->integer('selisih');
            $table->string('keterangan');
            $table->timestamps();  // Untuk mencatat waktu pembuatan dan pembaruan
            $table->index('id');
        });
        
        Schema::create('user_activity_logs', function (Blueprint $table) {
            $table->id();// Relasi ke tabel users
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('activity');           // Jenis aktivitas
            $table->text('description')->nullable(); // Keterangan aktivitas
            $table->dateTime('created');
            $table->dateTime('deleting_at');
            $table->index('id');
        });
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('logo_path');   
            $table->timestamps(); 
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('user_activity_logs');
        Schema::dropIfExists('stock_transactions');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_stock');
        Schema::dropIfExists('products');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
        Schema::dropIfExists('app_settings');

    }
}
