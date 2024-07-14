<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->unsignedBigInteger('default_billing_address_id')->nullable()->after('email');
        $table->foreign('default_billing_address_id')->references('id')->on('billing_addresses')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropForeign(['default_billing_address_id']);
        $table->dropColumn('default_billing_address_id');
    });
}

};
