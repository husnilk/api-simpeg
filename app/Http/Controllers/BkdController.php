<?php

namespace App\Http\Controllers;

use App\Models\Bkd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;

class BkdController extends Controller
{
    public function list_by_semester(Request $request, $tahun, String $semester)
    {
        $semester = ucfirst(strtolower($semester));
        $sql = "SELECT 
            bkdId as simpeg_id,
            bkdNama as nama,
            bkdPegId as pegawai_id,
            bkdNIP as nip,
            bkdNoSertifikasi as no_serdos,
            bkdFakultas as fakultas,
            bkdJenis as jenis,
            bkdKesimpulan1 as hasil_1,
            bkdKesimpulan2 as hasil_2,
            CASE WHEN bkdKesimpulan1='M' and bkdKesimpulan2='M' THEN 'M' ELSE 'T' END AS kesimpulan,
            ROUND(SUM(if(bkdpendRekomendasi IN (2, 3), replace(bkdpendKinerjaSks,',', '.'), 0)), 5) AS total_sks
        FROM sdm_bkd 
        LEFT JOIN sdm_bkd_bidang ON sdm_bkd_bidang.bkdpendBkdId=sdm_bkd.bkdId
        WHERE sdm_bkd.bkdTahunAkademik=? 
        AND sdm_bkd.bkdSemester=?
        GROUP BY bkdpendBkdId";

        $data = app('db')->select($sql, [$tahun, $semester]);
        $data = collect($data);

        if (!$data->count())
            return response()->json([
                'status' => 404,
                'description' => 'BKD not found!'
            ], 404);

        return response()->json([
            'tahun' => $tahun,
            'status' => 200,
            'periode' => $semester,
            'data' => $data
        ], 200);
    }

    public function list_by_unit(Request $request, $tahun, String $semester, $unit)
    {
        $semester = ucfirst(strtolower($semester));
        $data = Bkd::byUnit($tahun, $semester, $unit);

        if (!$data->count())
            return response()->json([
                'status' => 404,
                'description' => 'BKD not found!'
            ], 404);

        return response()->json([
            'status' => 200,
            'tahun' => $tahun,
            'periode' => $semester,
            'unit_id' => $unit,
            'data' => $data
        ], 200);
    }

    public function list_by_pegawai(Request $request, $tahun, String $semester, $pegawai)
    {
        $semester = ucfirst(strtolower($semester));

        $bkd = Bkd::where(['bkdTahunAkademik' => $tahun, 'bkdSemester' => $semester, 'bkdPegId' => $pegawai])->first();

        if (!$bkd)
            return response()->json([
                'status' => 404,
                'description' => 'BKD not found!'
            ], 200);

        return response()->json($bkd->byPegawai($tahun, $semester), 200);
    }
}
