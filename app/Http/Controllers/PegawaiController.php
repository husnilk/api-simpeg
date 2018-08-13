<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $list = Pegawai::list();
        return response()->json([
      'tanggal_request' => date("d-m-Y H:i:s"),
      'jumlah_data' => $list->count(),
      'data' => $list
    ], 200);
    }

    public function pegawai_unit(Request $request, $unit)
    {
        $unit = SatuanKerja::find($unit);

        if (!$unit) {
            return response()->json([
        'status' => 404,
        'description' => 'Unit not found!'
      ], 404);
        }

        $list = Pegawai::pegawai_unit($unit);
        return response()->json([
      'tanggal_request' => date("d-m-Y H:i:s"),
      'jumlah_data' => $list->count(),
      'unit_id' => $unit->satkerId,
      'unit_nama' => $unit->satkerNama,
      'data' => $list
    ], 200);
    }

    public function search($keyword)
    {
        $keyword = urldecode($keyword);
        $list = Pegawai::search($keyword);

        // $list = Pegawai::list();
        return response()->json([
            'tanggal_request' => date("d-m-Y H:i:s"),
            'jumlah_data' => $list->count(),
            'data' => $list
        ], 200);
    }

    public function detail($id)
    {
        $pegawai = Pegawai::find($id);
        if (!$pegawai) {
            return response()->json([
        'status' => 404,
        'description' => 'Pegawai not found!'
      ], 404);
        }

        return response()->json($pegawai->detail(), 200);
    }
}
