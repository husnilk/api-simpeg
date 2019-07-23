<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bkd extends Model
{
    protected $table = 'sdm_bkd';
    protected $primaryKey = 'bkdId';

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'bkdPegId', 'pegId');
    }

    public function kinerjas()
    {
        return $this->hasMany(Kinerja::class, 'bkdpendBkdId', 'bkdId');
    }

    public static function bySemester($tahun, $semester)
    {
        return Bkd::where('bkdTahunAkademik', $tahun)
                ->where('bkdSemester', $semester)
                ->get([
                  'bkdId as simpeg_id',
                  'bkdNama as nama',
                  'bkdPegId as pegawai_id',
                  'bkdNIP as nip',
                  'bkdNoSertifikasi as no_serdos',
                  'bkdFakultas as fakultas',
                  'bkdJenis as jenis',
                  'bkdKesimpulan1 as hasil_1',
                  'bkdKesimpulan1 as hasil_2'
                ]);
    }

    public static function byUnit($tahun, $semester, $unit)
    {
        return Bkd::where('bkdTahunAkademik', $tahun)
       ->where('bkdSemester', $semester)
       ->whereHas('pegawai', function ($q) use ($unit) {
           $q->whereHas('units', function ($x) use ($unit) {
               $x->where('satkerId', $unit);
           });
       })->get([
        'bkdId as simpeg_id',
        'bkdPegId as pegawai_id',
        'bkdNama as nama',
        'bkdNIP as nip',
        'bkdNoSertifikasi as no_serdos',
        'bkdFakultas as fakultas',
        'bkdJenis as jenis',
        'bkdKesimpulan1 as hasil_1',
        'bkdKesimpulan1 as hasil_2'
      ]);
    }

    public function byPegawai($tahun, $semester)
    {
        $data = new Bkd();
        $data->tahun = $tahun;
        $data->periode = $semester;
        $data->nama = $this->bkdNama;
        $data->nip = $this->bkdNIP;
        $data->kesimpulan = $this->kesimpulan();
        $data->no_serdos = $this->bkdNoSertifikasi;
        $data->fakultas = $this->bkdFakultas;
        $data->kinerja = $this->kinerjas()->get([
        'bkdpendBidBkd as bidang_bkd',
        'bkdpendJenisKegiatan as kegiatan',
        'bkdpendMasaPenugasan as masa_penugasan',
        'bkdpendBebanKerjaSks as sks_beban',
        'bkdpendKinerjaSks as sks_kinerja',
        'bkdpendRekomendasi as rekomendasi',
        'bkdPendSaranAsesor1 as saran_asesor_1',
        'bkdPendSaranAsesor2 as saran_asesor_2'
      ]);

        return $data;
    }

    public function kesimpulan()
    {
        if ($this->bkdKesimpulan1 == 'M' && $this->bkdKesimpulan2 == 'M') {
            return 'M';
        } else {
            return 'T';
        }
    }
}
