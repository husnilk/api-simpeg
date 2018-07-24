<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\SatuanKerjaPegawai;

class PegawaiController extends Controller
{
  public function index()
  {
    $list = Pegawai::list();
    return response()->json([
      'tanggal_request' => date("d-m-Y H:i:s"),
      'jumlah_data' => $list->count(),
      'data' => $list]);
  }
}
