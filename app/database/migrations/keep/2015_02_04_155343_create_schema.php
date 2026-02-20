<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchema extends Migration {

	/** 
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$file = file_get_contents(app_path().'/database/data/schema.sql', true);

        DB::unprepared($file);
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
