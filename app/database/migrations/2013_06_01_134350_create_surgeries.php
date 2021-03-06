<?php

use Illuminate\Database\Migrations\Migration;

class CreateSurgeries extends Migration {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('surgerytypes', function($table) {
            // auto incremental id (PK)
            $table->increments('id');

            $table->string('name', 32);

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        Schema::create('surgeries', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('person_id')->unsigned()->references('id')->on('people');
            $table->integer('surgerytype_id')->unsigned()->references('id')->on('surgerytypes');

            $table->date('date')->nullable();
            $table->boolean('completed')->default(false);
            $table->string('eyes', 5)->nullable();


            $table->string('surgery_notes', 64)->nullable();
            $table->string('ward', 20)->nullable();
	        $table->string('theatre', 20)->nullable();
            $table->string('outcome', 12)->nullable();

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        Schema::create('surgerydatatypes', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->string('name', 32);
            $table->string('label', 32);

            //whether the data field is only needed post surgery
            $table->boolean('post_surgery');

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

        //pivot table for many-to-many relationship between surgerytypes and surgerydatatypes
        Schema::create('surgerydataneeded', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('surgery_data_type_id')->unsigned()->references('id')->on('surgerydatatypes');
            $table->integer('surgery_type_id')->unsigned()->references('id')->on('surgerytypes');

            // created_at | updated_at DATETIME
//            $table->timestamps();
        });

        //pivot table for many-to-many relationship between surgerydatatypes and surgeries
        Schema::create('surgerydata', function($table) {
            // auto incremental id (PK)
            $table->increments('id');
            $table->integer('surgery_id')->unsigned()->references('id')->on('surgeries');
            $table->integer('surgery_data_type_id')->unsigned()->references('id')->on('surgerydatatypes');
            $table->string('value', 128);
            $table->string('eye', 1);

            // created_at | updated_at DATETIME
            $table->timestamps();
        });

		//options for surgerydatatypes
	    Schema::create('surgerydatatypeoptions', function($table) {
		    // auto incremental id (PK)
		    $table->increments('id');
		    $table->integer('surgerydatatype_id')->unsigned()->references('id')->on('surgerydatatypes');
		    $table->string('value', 32);
		    $table->integer('listorder');


		    // created_at | updated_at DATETIME
		    $table->timestamps();
	    });

    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('surgerydatatypeoptions');
        Schema::drop('surgerydataneeded');
        Schema::drop('surgerydata');
        Schema::drop('surgeries');
        Schema::drop('surgerytypes');
        Schema::drop('surgerydatatypes');

    }

}