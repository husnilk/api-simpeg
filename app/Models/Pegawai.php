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

  public function pendidikans()
  {
    return $this->belongsToMany(Pendidikan::class, 'sdm_pendidikan', 'pddkPegKode', 'pddkTkpddkrId')
                ->withPivot(
                  'pddkId as pendidikan_id',
                  'pddkInstitusi as institusi',
                  'pddkNegaraId as negara_institusi',
                  'pddkTglMulaiDinas as tgl_mulai_dinas',
                  'pddkTglSelesaiDinas as tgl_selesai_dinas',
                  'pddkThnLulus as tahun_lulus',
                  'pddkStatusTamat as status_tamat'
                );
  }

  public function fungsionals()
  {
    return $this->belongsToMany(Fungsional::class, 'sdm_jabatan_fungsional', 'jbtnPegKode', 'jbtnJabfungrId')
                ->withPivot(
                  'jbtnId as jabatan_id',
                  'jbtnTmt as tmt',
                  'jbtnStatus as jabatan_status'
                );
  }

  public function strukturals()
  {
    return $this->belongsToMany(Struktural::class, 'sdm_jabatan_struktural', 'jbtnstrukPegKode', 'jbtnJabstrukrId')
                ->withPivot(
                  'jbtnstrukId as jabatan_id',
                  'jbtnstrukTmt as tmt',
                  'jbtnstrukTglSelesai as tanggal_selesai',
                  'jbtnstrukStatus as status'
                );
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

  public function detail()
  {
    $data = new Pegawai();
    $data->id = $this->pegId;
    $data->nip = $this->pegNip;
    $data->nama = $this->pegNama;
    $data->nidn = $this->pegNidn;
    $data->tanggal_lahir = $this->pegTglLahir;
    $data->tempat_lahir = $this->pegTmpLahirTeks;
    $data->jenis_kelamin = $this->pegGender;
    $data->kategori = $this->pegKatPegawai;
    $data->jenis_pegawai = $this->pegStatrId;
    $data->npwp = $this->pegNPWP;
    $data->agama = $this->pegAgamaId;
    $data->no_hp = $this->pegNoHp;
    $data->email = $this->pegEmail;
    $data->unit = $this->units()->select([
                    'satkerId as id',
                    'satkerNama as nama'
                  ])->first();

    $data->pendidikan = $this->pendidikans()->get([
                          'pendId as jenjang_id'
                        ]);

    $data->fungsional = $this->fungsionals()->get([
                          'jabfungrNama as jabatan'
                        ]);

    $data->jabatan = $this->strukturals()->get([
                          'jabstrukrNama as jabatan'
                        ]);
    return $data;
  }
}
