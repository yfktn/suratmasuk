<?php namespace Yfktn\SuratMasuk\Models;

use Model;

/**
 * Model
 */
class SuratMasuk extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'yfktn_suratmasuk_';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'hal' => 'required',
        'nomor' => 'required',
        'tanggal' => 'required',
        'dari' => 'required',
    ];

    public $attachMany = [
        'daftarDokumen' => 'System\Models\File'
    ];

    /**
     * Ini untuk tampilan singkat informasi trigger nya.
     * implementasi Yfktn\BerikanArahan\Classes\InterfaceTampilanSingkatTrigger
     * @return array 
     */
    public function getArrayAssocTampilanSingkat()
    {
        $dokumen = [];
        if($this->daftarDokumen) {
            foreach($this->daftarDokumen as $dok) {
                $dokumen[] = "<a target='_blank' href='{$dok->path}'><i class='icon-file'></i> {$dok->file_name}</a>";
            }
        }
        return [
            'Pengirim' => $this->dari,
            'Nomor Surat' => $this->nomor,
            'Hal Surat' => $this->hal,
            'Tanggal Surat' => \Carbon\Carbon::createFromFormat('Y-m-d', $this->tanggal)->format('d-m-Y'),
            'Dokumen' => $dokumen
        ];
    }

    /**
     * Ini untuk memberikan label juga digunakan karena ini akan dijadikan bagian dari
     * implementasi Yfktn\BerikanArahan\Classes\InterfaceTampilanSingkatTrigger
     * @return string 
     */
    public function getLabel()
    {
        $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $this->tanggal)->format('d-m-Y');
        return "Surat Dari {$this->dari} Nomor {$tanggal} Hal {$this->hal}";
    }

    public function getTingkatKeamananOptions()
    {
        return [
            'sangat rahasia' => 'Sangat Rahasia',
            'rahasia' => 'Rahasia',
            'biasa' => 'Biasa',
        ];
    }

    public function getTingkatKeamananAttribute($value)
    {
        $options = $this->getTingkatKeamananOptions();
        return isset($options[$value])? $options[$value]: 'Biasa';
    }

    public function getKecepatanPenyampaianOptions()
    {
        return [
            'sangat segera' => 'Sangat Segera / Kilat',
            'segera' => 'Segera',
            'biasa' => 'Biasa'
        ];
    }

    public function getKecepatanPenyampaianAttribute($value)
    {
        $options = $this->getKecepatanPenyampaianOptions();
        return isset($options[$value])? $options[$value]: 'Biasa';
    }
    
}
