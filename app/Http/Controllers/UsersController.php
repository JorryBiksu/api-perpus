<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Helper\CustomController;
use Illuminate\Support\Facades\Hash;

class UsersController extends CustomController{

    public function store()
    {
        try {
            $body = $this->parseRequestBody();
            $data = [
                'nama' => $body['nama'],
                'username' => $body['username'],
                'telp' => $body['telp'],
                'alamat' => $body['alamat'],
                'role' => 'PEMINJAM',
                'password' => Hash::make($body['password']),
            ];
            $occupant = Users::create($data);
            return $this->jsonCreatedResponse('success', $occupant);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error ' . $e->getMessage());
        }
    }
    
    public function login()
    {
        try {
            $username = $this->postField('username');
            $password = $this->postField('password');

            $user = Users::with([])
                ->where('username', '=', $username)
                ->where('role', '=', 'PEMINJAM')
                ->first();
            if (!$user) {
                return $this->jsonNotFoundResponse('user not found');
            }

            $isPasswordValid = Hash::check($password, $user->password);
            if (!$isPasswordValid) {
                return $this->jsonUnauthorizedResponse('password did not match');
            }

            return $this->jsonSuccessResponse('Login Success',$user);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error '.$e->getMessage());
        }
    }
    
    public function loginPetugas()
    {
        try {
            $username = $this->postField('username');
            $password = $this->postField('password');

            $user = Users::with([])
                ->where('username', '=', $username)
                ->where('role', '!=', 'PEMINJAM')
                ->first();
            if (!$user) {
                return $this->jsonNotFoundResponse('user not found');
            }

            $isPasswordValid = Hash::check($password, $user->password);
            if (!$isPasswordValid) {
                return $this->jsonUnauthorizedResponse('password did not match');
            }

            return $this->jsonSuccessResponse('Login Success',$user);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse('internal server error '.$e->getMessage());
        }
    }
}