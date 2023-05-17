<?php

namespace App\Http\Controllers;

use App\Models\Perpustakaan;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Exception;

class PerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $perpustakaans = Perpustakaan::all();
            if ($perpustakaans) {
                return ApiFormatter::createAPI(200, 'success', $perpustakaans);
            }else {
                return ApiFormatter::createAPI(400, 'failed');
            }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        $request->validate([
            'tanggal' => 'required',
            'judul' => 'required',
            'penerbit' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
        ]);
        
        $perpustakaans = Perpustakaan::create([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'penerbit' =>  $request->penerbit,
            'jenis' =>  $request->jenis,
            'harga' =>  $request->harga,
        ]);
        $hasilTambahData = Perpustakaan::where('id', $perpustakaans->id)->first();
        if ($hasilTambahData) {
            return ApiFormatter::createAPI(200, 'success', $hasilTambahData
        );
        }else {
            return ApiFormatter::createAPI(400, 'failed');
        }
     } catch(Exception $error) {
        // munculkan deskripsi error yg bakal tampil di property data jsonnya
         return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

public function createToken()
{
    return csrf_token();
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // coba baris kode didalam try
        try{
        $perpustakaans = Perpustakaan::find($id);
        if ($perpustakaans) {
            return ApiFormatter::createAPI(200, 'success', $perpustakaans);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    } catch(Exception $error) {
         return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perpustakaan $perpustakaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        try {
        // cek validasi inputan pada body postman
        $request->validate([
            'tanggal' => 'required',
            'judul' => 'required',
            'penerbit' => 'required',
            'jenis' => 'required',
            'harga' => 'required',
        ]);
        // ambil data yang akan diubah
        $perpustakaans = Perpustakaan::find($id);
        // update data yang telah diambil diatas
        $perpustakaans->update([
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'penerbit' =>  $request->penerbit,
            'jenis' =>  $request->jenis,
            'harga' =>  $request->harga,
        ]);
        // cari data yang berhasil diubah tadi, cari berdasarkan id dari $student yg ngambil data diawal
        $dataTerbaru = Perpustakaan::where('id', $perpustakaans->id)->first();
        if ($dataTerbaru) {
            // jika update berhsil tampilkan data dari $updateStudent diatas (data yg sudah berhasil diubah)
            return ApiFormatter::createAPI(200, 'success', $dataTerbaru);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    } catch(Exception $error) {
        // jika di baris kode try ada trouble, error dimunculkan dengan desc error nya dengan status code 400
         return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // ambil data yang mau dihapus
            $perpustakaans = Perpustakaan::find($id);
            // hapus data yg diambil diatas
            $cekBerhasil = $perpustakaans->delete();
            if ($cekBerhasil) {
                // kalau berhasil hapus data yg dimuncukan teks confirm dengan status code 200 
                return ApiFormatter::createAPI(200, 'success', 'Data Terhapus!');
            } else {
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch(Exception $error) {
            // kalau ada trouble, error dimunculkan dengan desc error nya dengan status code 400
             return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
        
    }


public function trash()
{
    try {
        // ambil data yang sudah dihapus sementara
        $perpustakaans = Perpustakaan::onlyTrashed()->get();
        if ($perpustakaans) {
            // kalau data berhasil terambil , tampilkan status 200 dengan data dari $students
            return ApiFormatter::createAPI(200, 'success', $perpustakaans);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    } catch(Exception $error) {
        // kalau ada error di try, catch akan menampilkan desc errornya
         return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
    
}

public function restore($id)
{
    try {
        // ambil data yg akan di batal hapus, diambil berdasarkan id dari route nya
        $perpustakaans = Perpustakaan::onlyTrashed()->where('id', $id);
        // kembalikan data
        $perpustakaans->restore();
        // ambil kembali data yg sudah di restore
        $dataKembali = Perpustakaan::where('id', $id)->first();
        if ($dataKembali) {
            // jika seluruh prosesnya dpat dijalankan, data yg sdh dikembalikan dan diambil tdi ditampilkan pada response 200
            return ApiFormatter::createAPI(200, 'success', $dataKembali);
        } else {
            return ApiFormatter::createAPI(400, 'failed');
        }
    }catch(Exception $error) {
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}

public function permanentDelete($id)
{
    try {
        // ambil data yg akan di hapus
        $perpustakaans = Perpustakaan::onlyTrashed()->where('id', $id);
        // hapus permanen data yg diambil
        $proses = $perpustakaans->forceDelete();          
        if ($proses) {
        return ApiFormatter::createAPI(200, 'success', 'Berhasil hapus permanen!');
    } else {
        return ApiFormatter::createAPI(400, 'failed');
    }
    }catch(Exception $error) {
        return ApiFormatter::createAPI(400, 'error', $error->getMessage());
    }
}
}

