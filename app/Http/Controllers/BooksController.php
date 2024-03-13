<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use App\Helper\CustomController;
use Illuminate\Support\Facades\File;

class BooksController extends CustomController{


    public function index()
    {
        $data = Books::with(['kategori:id,nama'])->orderBy('created_at', 'DESC')->get();
        if (!$data) {
            return $this->jsonNotFoundResponse('not found!');
        }
        return $this->jsonSuccessResponse('success', $data);
    }

    public function store(Request $request)
{
    try {
        // Validasi request untuk memastikan bahwa gambar telah disertakan
        if ($request->hasFile('gambar')) {
            $body = $this->parseRequestBody();
            
            // Menyimpan gambar ke dalam sistem penyimpanan Anda
            $gambar = time().'.'.$request->gambar->extension();  
            $request->gambar->move(('images'), $gambar);
    
            // Data buku yang akan disimpan
            $data = [
                'kategori_id' => $body['kategori_id'],
                'judul' => $body['judul'],
                'penulis' => $body['penulis'],
                'penerbit' => $body['penerbit'],
                'sinopsis' => $body['sinopsis'],
                'gambar' => $gambar, // Menyimpan nama gambar dalam basis data
                'tahun_terbit' => $body['tahun_terbit'],
            ];
            $add = Books::create($data);
            return $this->jsonCreatedResponse('success', $add);
        } else {
            return $this->jsonErrorResponse('Gambar tidak ditemukan dalam request.');
        }
    } catch (\Throwable $e) {
        return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
    }
}


    public function getByID($id)
    {
        try {
            $data = Books::with([])->where('id', '=', $id)->first();
            if (!$data) {
                return $this->jsonNotFoundResponse(' not found');
            }
            if ($this->request->method() === 'POST') {
                return $this->patch($data);
            }
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
        }
    }

    private function patch($data)
    {
        $body = $this->parseRequestBody();
        $data_request = [
            'kategori_id' => $body['kategori_id'],
            'judul' => $body['judul'],
            'penulis' => $body['penulis'],
            'penerbit' => $body['penerbit'],
            'gambar' => $body['gambar'],
            'tahun_terbit' => $body['tahun_terbit'],
        ];
        $data->update($data_request);
        return $this->jsonCreatedResponse('success');
    }

}