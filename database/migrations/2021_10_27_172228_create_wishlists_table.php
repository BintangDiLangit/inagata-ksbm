<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wishlists', function (Blueprint $table) {
			$table->id('id_wishlist');
			$table->unsignedBigInteger('id_produk');
			$table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
			$table->unsignedBigInteger('id_user');
			$table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
		Schema::dropIfExists('wishlists');
	}
}
