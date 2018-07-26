<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fungsional extends Model
{
  protected $table = 'pub_ref_jabatan_fungsional';
  protected $primaryKey = 'jabfungrId';
  protected $hidden = ['pivot'];

  public function pegawais()
  {
    return $this->belongsToMany(Pegawai::class, 'sdm_jabatan_fungsional', 'jbtnJabfungrId', 'jbtnPegKode');
  }
}
