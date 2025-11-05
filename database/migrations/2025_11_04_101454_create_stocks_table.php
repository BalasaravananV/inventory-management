<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('stocks', function (Blueprint $table) {
        $table->bigIncrements('st_id'); // primary key
        $table->unsignedBigInteger('pr_id'); // product_id
        $table->unsignedBigInteger('wh_id'); // warehouse_id
        $table->integer('quantity')->default(0);
        $table->date('expires_at')->nullable();
        $table->integer('status')->default(1)->comment('1 = Active, 2 = Inactive, 3 = Deleted');
        $table->timestamps();

        // indexes and unique constraint
        $table->unique(['pr_id', 'wh_id'], 'stock_pr_id_wh_id_unique');
        $table->index('wh_id', 'stock_wh_id_foreign');

        // if you want foreign keys (recommended if warehouses/products exist)
        // $table->foreign('pr_id')->references('pr_id')->on('products')->onDelete('cascade');
        // $table->foreign('wh_id')->references('wh_id')->on('warehouses')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
