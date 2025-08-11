<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTables extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('name');
            $table->index('stock');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('type');
            $table->index('transaction_date');
        });
        
        Schema::table('admins', function (Blueprint $table) {
            $table->index('email');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['stock']);
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['type']);
            $table->dropIndex(['transaction_date']);
        });
        
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
    }
}