<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddSlugsToTablesWithDataHandling extends Migration
{
    public function up()
    {
        // Add slug columns without unique constraint first
        Schema::table('admins', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });

        // Update existing data with slugs
        $this->updateExistingData();

        // Now add unique constraints
        Schema::table('admins', function (Blueprint $table) {
            $table->unique('slug');
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->unique('slug');
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->unique('slug');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    private function updateExistingData()
    {
        // Update Admins
        $admins = DB::table('admins')->get();
        foreach ($admins as $admin) {
            $slug = Str::slug($admin->first_name . '-' . $admin->last_name) . '-' . $admin->id . '-' . time();
            DB::table('admins')->where('id', $admin->id)->update(['slug' => $slug]);
        }

        // Update Categories
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $slug = Str::slug($category->name) . '-' . $category->id;
            DB::table('categories')->where('id', $category->id)->update(['slug' => $slug]);
        }

        // Update Products
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $slug = Str::slug($product->name) . '-' . $product->id . '-' . time();
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }

        // Update Transactions
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $transaction) {
            $slug = Str::slug($transaction->transaction_code) . '-' . $transaction->id;
            DB::table('transactions')->where('id', $transaction->id)->update(['slug' => $slug]);
        }
    }
}