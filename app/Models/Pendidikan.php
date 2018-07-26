<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
  protected $table = 'pub_ref_pendidikan';
  protected $primaryKey = 'pendId';
  protected $hidden = ['pivot'];

  public function pegawais()
  {
    return $this->belongsToMany(Pegawai::class, 'sdm_pendidikan', 'pddkTkpddkrId', 'pddkPegKode');
  }
}
