<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaksis', function (Blueprint $table) {
			$table->id('id_transaksi');
			$table->string('status')->default('PENDING');
			$table->unsignedBigInteger('id_user');
			$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
			$table->unsignedBigInteger('id_produk');
			$table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('transaksis');
	}
}
