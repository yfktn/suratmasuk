<?php namespace Yfktn\SuratMasuk\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateYfktnSuratmasuk extends Migration
{
    public function up()
    {
        Schema::create('yfktn_suratmasuk_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('dari', 2024);
            $table->string('hal', 2024);
            $table->string('nomor', 250)->unique();
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('yfktn_suratmasuk_');
    }
}