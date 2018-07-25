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
      'pegId as id',
      'pegNip as nip',
      'pegNama as nama',
      'pegNidn as nidn',
      'pegTglLahir as tanggal_lahir',
      'pegTmpLahirTeks as tempat_lahir',
      'pegGender as jenis_kelamin',
      'pegKatPegawai as kategori',
      'pegStatrId as jenis_pegawai',
      'pegNPWP as npwp'
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

  public static function pegawai_unit($unit)
  {
    return $unit->pegawais()->get([
      'pegId as id',
      'pegNip as nip',
      'pegNama as nama',
      'pegNidn as nidn',
      'pegTglLahir as tanggal_lahir',
      'pegTmpLahirTeks as tempat_lahir',
      'pegGender as jenis_kelamin',
      'pegKatPegawai as kategori',
      'pegStatrId as jenis_pegawai',
      'pegNPWP as npwp'
    ]);
  }
}
