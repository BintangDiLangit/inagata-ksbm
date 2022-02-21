<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryProduksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery_produks', function (Blueprint $table) {
			$table->id('id_gallery_produk');
			$table->string('url');
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
		Schema::dropIfExists('gallery_produks');
	}
}
