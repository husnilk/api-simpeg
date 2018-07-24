<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
  protected $table = 'pub_pegawai';
  protected $primaryKey = 'pegId';
  protected $hidden = ['pivot'];

  public static function list()
  {
    $pegawais = Pegawai::all([
      'pub_pegawai.pegId as id',
      'pub_pegawai.pegNip as nip',
      'pub_pegawai.pegNama as nama',
      'pub_pegawai.pegNidn as nidn',
      'pub_pegawai.pegTglLahir as tanggal_lahir',
      'pub_pegawai.pegTmpLahirTeks as tempat_lahir',
      'pub_pegawai.pegGender as jenis_kelamin',
      'pub_pegawai.pegKatPegawai as kategori',
      'pub_pegawai.pegStatrId as jenis_pegawai',
      'pub_pegawai.pegNPWP as npwp'
    ]);

    return $pegawais->filter(function($p){
      $p->unit = Pegawai::find($p->id)->units()->select([
        'satkerId as id',
        'satkerNama as nama'
      ])->first();

      return $p;
    });
  }

  public function units()
  {
    return $this->belongsToMany(SatuanKerja::class, 'sdm_satuan_kerja_pegawai', 'satkerpegPegId', 'satkerpegSatkerId')
                ->wherePivot('satkerpegAktif', 'Aktif');
  }

  // public function getUnitIdAttribute()
  // {
  //   if ($sat = $this->units->first()) {
  //     return $sat->satkerId;
  //   }
  //
  //   return null;
  // }
  //
  // public function getUnitNamaAttribute()
  // {
  //   if ($sat = $this->units->first()) {
  //     return $sat->satkerNama;
  //   }
  //
  //   return null;
  // }
}
