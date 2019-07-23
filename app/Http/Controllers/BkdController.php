<?php

namespace App\Http\Controllers;

use App\Models\Bkd;
use Illuminate\Http\Request;

class BkdController extends Controller
{
  public function list_by_semester(Request $request, $tahun, String $semester)
  {
    $semester = ucfirst(strtolower($semester));
    $data = Bkd::bySemester($tahun, $semester);

    if(!$data->count())
      return response()->json([
        'status' => 404,
        'description' => 'BKD not found!'
      ], 404);

    return response()->json([
      'tahun' => $tahun,
      'periode' => $semester,
      'data' => $data
    ], 200);
  }

  public function list_by_unit(Request $request, $tahun, String $semester, $unit)
  {
    $semester = ucfirst(strtolower($semester));
    $data = Bkd::byUnit($tahun, $semester, $unit);

    if(!$data->count())
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

    if(!$bkd)
      return response()->json([
        'status' => 404,
        'description' => 'BKD not found!'
      ], 404);

    return response()->json($bkd->byPegawai($tahun, $semester), 200);
  }
}
