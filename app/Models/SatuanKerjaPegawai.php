<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SatuanKerjaPegawai extends Model
{
  protected $table = 'sdm_satuan_kerja_pegawai';
  protected $primaryKey = 'satkerpegId';
}
