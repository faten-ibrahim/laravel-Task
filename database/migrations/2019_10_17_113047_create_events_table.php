<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *main title (required, min:3 , max:150)
      *  secondary title ( min:3 , max:150)
       * contedate (calendar make sure past date not selected)
        *end-dnt (ckeditor)
        *start-ate (calendar make sure it will be after start date)
        *location
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('main_title',150);
            $table->string('secondary_title',150)->nullable();
            $table->text('content');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location')->nullable();
            $table->double('location_lat')->nullable();
            $table->double('location_lang')->nullable();
            $table->boolean('is_published')->default(false);
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
        Schema::dropIfExists('events');
    }
}
