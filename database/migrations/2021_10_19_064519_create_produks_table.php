<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('produks', function (Blueprint $table) {
			$table->id('id_produk');
			$table->string('nama_produk');
			$table->float('harga');
			$table->longText('deskripsi_produk');
			$table->string('tags')->nullable();
			$table->string('slug')->unique();
			$table->softDeletes();
			$table->unsignedBigInteger('id_kategori_produk');
			$table->foreign('id_kategori_produk')->references('id_kategori_produk')->on('kategori_produks')->onDelete('cascade');
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
		Schema::dropIfExists('produks');
	}
}
