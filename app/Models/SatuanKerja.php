<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
  protected $table = 'pub_satuan_kerja';
  protected $primaryKey = 'satkerId';
  protected $hidden = ['pivot'];

  public function pegawais()
  {
    return $this->belongsToMany(Pegawai::class, 'sdm_satuan_kerja_pegawai', 'satkerpegSatkerId', 'satkerpegPegId')
                ->wherePivot('satkerpegAktif', 'Aktif');
  }
}
