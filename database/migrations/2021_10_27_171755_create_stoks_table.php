<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stoks', function (Blueprint $table) {
			$table->id('id_stok');
			$table->bigInteger('jumlah_stok');
			$table->string('size');
			$table->string('warna');
			$table->unsignedBigInteger('id_produk');
			$table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
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
		Schema::dropIfExists('stoks');
	}
}
