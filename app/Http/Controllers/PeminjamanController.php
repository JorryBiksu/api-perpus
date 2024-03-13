<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Helper\CustomController;

class PeminjamanController extends CustomController{

    public function index()
    {
        $data = Peminjaman::with(['user','book'])->orderBy('created_at', 'DESC')->get();
        if (!$data) {
            return $this->jsonNotFoundResponse('not found!');
        }
        return $this->jsonSuccessResponse('success', $data);
    }

    public function getByUser($id)
    {
        try {
            $data = Peminjaman::with(['book'])->where('user_id', '=', $id)->get();
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found');
            }
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
        }
    }

    public function store()
    {
        try {
            $body = $this->parseRequestBody();
            $data = [
                'user_id' => $body['user_id'],
                'book_id' => $body['book_id'],
                'tanggal_pinjam' => $body['tanggal_pinjam'],
                'tanggal_kembali' => $body['tanggal_kembali'],
                'status' => "DIPINJAM",
            ];
            $add = Peminjaman::create($data);
            return $this->jsonCreatedResponse('success', $add);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
        }
    }
}