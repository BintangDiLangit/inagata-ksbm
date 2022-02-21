<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('detail_transaksis', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('id_transaksi');
			$table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
			$table->string('pembayaran')->default('MANUAL');
			$table->integer('jumlah');
			$table->bigInteger('harga_total');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('detail_transaksis');
	}
}
