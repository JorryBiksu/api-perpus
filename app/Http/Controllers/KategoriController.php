<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Helper\CustomController;

class KategoriController extends CustomController{


    public function index()
    {
        $data = Kategori::with([])->orderBy('created_at', 'DESC')->get();
        if (!$data) {
            return $this->jsonNotFoundResponse('not found!');
        }
        return $this->jsonSuccessResponse('success', $data);
    }

    public function getByID($id)
    {
        try {
            $data = Kategori::with([])->where('id', '=', $id)->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found');
            }
            if ($this->request->method() === 'POST') {
                return $this->patch($data);
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
                'nama' => $body['nama'],
            ];
            $add = Kategori::create($data);
            return $this->jsonCreatedResponse('success', $add);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
        }
    }

    private function patch($data)
    {
        $body = $this->parseRequestBody();
        $data_request = [
            'nama' => $body['nama'],
        ];
        $data->update($data_request);
        return $this->jsonCreatedResponse('success');
    }
}