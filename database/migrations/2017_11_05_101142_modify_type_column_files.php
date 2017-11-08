<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTypeColumnFiles extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'files', function ( Blueprint $table ) {
			$table->string( 'filetype' )->nullable();

		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'files', function ( Blueprint $table ) {
			$table->dropColumn( 'filetype' );
		} );
	}
}
