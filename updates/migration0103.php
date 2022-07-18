<?php namespace Yfktn\SuratMasuk\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration0103 extends Migration
{
    public function up()
    {
        Schema::table('yfktn_suratmasuk_', function($table)
        {
            $table->string('tingkat_keamanan', 50)->index()->nullable();
            $table->string('kecepatan_penyampaian', 50)->index()->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('yfktn_suratmasuk_', function($table)
        {
            $table->dropColumn('tingkat_keamanan');
            $table->dropColumn('kecepatan_penyampaian');
        });
    }
}