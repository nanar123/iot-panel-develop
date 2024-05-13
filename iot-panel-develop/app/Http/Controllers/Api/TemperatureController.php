<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemperatureController extends Controller
{
  function getTemperature()
  {
    // Mengambil semua data temperature
    $temperature = Temperature::all();

    // Mengembalikan response dalam bentuk JSON
    // dan status code 200
    return response()->json([
      "message" => "Data temperature berhasil diambil",
      "data" => $temperature
    ], 200);
  }

  function insertTemperature(Request $request)
  {
    // 1. Validasi data request
    $validator = Validator::make($request->all(), [
      'temperature' => 'required|numeric',
    ]);

    if ($validator->fails()) {
      return response()->json(["errors" => $validator->errors()], 400);
    }

    // 2. Menambahkan data temperature
    $temperature = Temperature::create([
      'value' => $request->temperature
    ]);

    // 3. Mengembalikan response JSON
    // dengan status code 201
    return response()->json([
      "message" => "Data temperature berhasil ditambahkan",
      "data" => $temperature
    ], 201);
  }

  function updateTemperature(Request $request, $id)
  {
    // 1. Validasi data request
    $validator = Validator::make($request->all(), [
      'temperature' => 'required|numeric',
    ]);

    if ($validator->fails()) {
      return response()->json(["errors" => $validator->errors()], 400);
    }

    // 2. Mencari data temperature berdasarkan ID
    $temperature = Temperature::find($id);

    // 3. Pengecekan data ditemukan
    if (!$temperature) {
      return response()->json(["message" => "Data temperature tidak ditemukan"], 404);
    }

    // 4. Update data temperature
    $temperature->update([
      'value' => $request->temperature
    ]);

    // 5. Mengembalikan response JSON
    return response()->json([
      "message" => "Data temperature berhasil diperbarui",
      "data" => $temperature
    ], 200);
  }

  function deleteTemperature($id)
  {
    // 1. Mencari data temperature berdasarkan ID
    $temperature = Temperature::find($id);

    // 2. Pengecekan data ditemukan
    if (!$temperature) {
      return response()->json(["message" => "Data temperature tidak ditemukan"], 404);
    }

    // 3. Hapus data temperature
    $temperature->delete();

    // 4. Mengembalikan response JSON
    return response()->json([
      "message" => "Data temperature berhasil dihapus",
    ], 200);
  }
}