<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBillingAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('billing_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->nullable()
                  ->constrained('customers')
                  ->onDelete('cascade');
            $table->string('address_name');
            $table->text('address');
            $table->string('contact_number')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('billing_addresses');
    }
}
