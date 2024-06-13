<?php namespace Yfktn\SuratMasuk;

use Event;
use Illuminate\Support\Facades\DB;
use Log;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        Event::listen('yfktn.berikanarahan.layananbelumdiarahkan', function() {
            $sql = <<<SQLNYA
SELECT 
    sm.id, 
    CONCAT('Surat Masuk Dari ', dari, ' Nomor ', nomor, ' Hal ', hal) AS label,
    'Yfktn\\SuratMasuk\\Models\\SuratMasuk' AS model
FROM yfktn_suratmasuk_ as sm 
LEFT JOIN yfktn_berikanarahan_ as ba ON ba.berdasarkan_id = sm.id 
    AND ba.berdasarkan_type = 'Yfktn\\SuratMasuk\\Models\\SuratMasuk' WHERE ba.id IS NULL
SQLNYA;
            $data = DB::select(str_replace("\\", "\\\\", $sql));
            if(!$data) {
                return [];
            }
            $a = [];
            foreach($data as $d) {
                $a[$d->id . '|' . $d->model] = $d->label;
            }
            return $a;
        });

        Event::listen('yfktn.berikanarahan.layananpencariantrigger', function($condition, $value) {
            $params = [];
            if($condition === 'equals') {
                $sql = <<<SQLNYA
                    SELECT ba.id FROM yfktn_suratmasuk_ sm 
                    JOIN yfktn_berikanarahan_ ba ON ba.berdasarkan_id = sm.id AND ba.berdasarkan_type = 'Yfktn\\SuratMasuk\\Models\\SuratMasuk'
                    WHERE sm.nomor = :value
                SQLNYA;
                $params = ['value' => $value];
            } else {
                $sql = <<<SQLNYA
                    SELECT ba.id FROM yfktn_suratmasuk_ sm 
                    JOIN yfktn_berikanarahan_ ba ON ba.berdasarkan_id = sm.id 
                        AND ba.berdasarkan_type = 'Yfktn\\SuratMasuk\\Models\\SuratMasuk'
                    WHERE sm.dari LIKE :param1 OR sm.nomor LIKE :param2 OR sm.hal LIKE :param3
                SQLNYA;
                $params = [
                    'param1' => "%" . $value . "%",
                    'param2' => "%" . $value . "%",
                    'param3' => "%" . $value . "%",
                ];
            }
            $data = DB::select(str_replace("\\", "\\\\", $sql), $params);
            if(!$data) {
                return [];
            }
            return array_column($data, 'id');
        });
    }

}
