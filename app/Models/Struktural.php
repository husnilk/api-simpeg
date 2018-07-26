<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struktural extends Model
{
  protected $table = 'sdm_ref_jabatan_struktural';
  protected $primaryKey = 'jabstrukrId';
  protected $hidden = ['pivot'];

  public function pegawais()
  {
    return $this->belongsToMany(Pegawai::class, 'sdm_jabatan_struktural', 'jbtnJabstrukrId', 'jbtnstrukPegKode');
  }
}
