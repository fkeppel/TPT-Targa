<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PPTermine', function(Blueprint $table)
		{
			$table->increments('PPTermine_Id');
			$table->BigInteger('PPTermine_PPProjekte_Id');
			
			$table->dateTime('PPTermine_DatumStart'); 
			$table->dateTime('PPTermine_DatumEnde'); 
			$table->string('PPTermine_Header', 100);
			$table->string('PPTermine_Art', 100);
			$table->string('PPTermine_Typ', 100);
			$table->integer('PPTermine_MAAnlage');
			$table->integer('PPTermine_MAZustaendigkeit');
			$table->string('PPTermine_Status', 100);
			$table->longText('PPTermine_Bemerkungen');
			$table->timestamps();
		});

		Schema::create('PPTermineAnhaenge', function(Blueprint $table)
		{
			$table->increments('PPTermineAnhaenge_Id');
			$table->BigInteger('PPTermineAnhaenge_PPTermine_Id');
			$table->timestamps();
			$table->string('PPTermineAnhaenge_Datei', 255);
			$table->LongText('PPTermineAnhaenge_Bemerkung');
			$table->dateTime('PPTermineAnhaenge_UploadeDatum'); 
			$table->integer('PPTermineAnhaenge_UploadMA');
		});
			
		Schema::create('PPTermineHistory', function(Blueprint $table)
		{
			$table->increments('PPTermineHistory_Id');
			$table->BigInteger('PPTermineHistory_PPTermine_Id');
			$table->dateTime('PPTermineHistory_Datum'); 
			$table->integer('PPTermineHistory_MA');

			$table->dateTime('PPTermineHistory_DatumStart'); 
			$table->dateTime('PPTermineHistory_DatumEnde'); 
			$table->string('PPTermineHistory_Header', 100);
			$table->string('PPTermineHistory_Art', 100);
			$table->string('PPTermineHistory_Typ', 100);
			$table->integer('PPTermineHistory_MAAnlage');
			$table->integer('PPTermineHistory_MAZustaendigkeit');
			$table->string('PPTermineHistory_Status', 100);
			$table->longText('PPTermineHistory_Bemerkungen');

			$table->timestamps();
		});
	Schema::create('PPMitarbeiter', function(Blueprint $table)
		{
			$table->increments('PPMitarbeiter_Id');

			$table->string('PPMitarbeiter_Name', 100);
			$table->string('PPMitarbeiter_Vorname', 100);
			$table->string('PPMitarbeiter_Kuerzel', 100);
			$table->string('PPMitarbeiter_User', 100);
			$table->string('PPMitarbeiter_Password', 100);

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
		Schema::drop('PPTermine');
	}

}
