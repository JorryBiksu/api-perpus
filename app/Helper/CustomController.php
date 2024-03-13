<?php


namespace App\Helper;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;


class CustomController extends Controller
{
    /** @var Request $request */
    protected $request;

    /**
     * CustomController constructor.
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    public function postField($key)
    {
        return $this->request->request->get($key);
    }

    public function field($key)
    {
        return $this->request->query->get($key);
    }

    public function parseRequestBody()
    {
        return $this->request->all();
    }

    public function jsonResponse($msg = '', $status = 200, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => $data
        ], $status);
    }

    public function jsonSuccessResponse($msg = '', $data = null)
    {
        return response()->json([
            'status' => 200,
            'message' => $msg,
            'data' => $data
        ], 200);
    }

    public function jsonCreatedResponse($msg = '', $data = null)
    {
        return response()->json([
            'status' => 201,
            'message' => $msg,
            'data' => $data
        ], 201);
    }

    public function jsonAcceptedResponse($msg = '', $data = null)
    {
        return response()->json([
            'status' => 202,
            'message' => $msg,
            'data' => $data
        ], 202);
    }

    public function jsonNotFoundResponse($msg = 'item not found!', $data = null)
    {
        return response()->json([
            'status' => 404,
            'message' => $msg,
            'data' => $data
        ], 404);
    }

    public function jsonUnauthorizedResponse($msg = 'unauthorized', $data = null)
    {
        return response()->json([
            'status' => 401,
            'message' => $msg,
            'data' => $data
        ], 401);
    }

    public function jsonBadRequestResponse($msg = '', $data = null, $errors = null)
    {
        return response()->json([
            'status' => 400,
            'message' => $msg,
            'data' => $data,
            'errors' => $errors
        ], 400);
    }

    public function jsonForbiddenResponse($msg = '', $data = null, $errors = null)
    {
        return response()->json([
            'status' => 403,
            'message' => $msg,
            'data' => $data
        ], 403);
    }

    public function jsonErrorResponse($msg = '', $data = null)
    {
        return response()->json([
            'status' => 500,
            'message' => 'internal server error ' . $msg,
            'data' => $data
        ], 500);
    }

    public function generateTokenById($id, $role)
    {

        return auth('api')->setTTL(null)
            ->claims([
                'role' => $role,
            ])->tokenById($id);
    }

    public function generateToken($credentials, $role)
    {
        return auth('api')->setTTL(null)->claims([
            'role' => $role
        ])->attempt($credentials);
    }

    public function check_role($role)
    {
        $available_role = [
            'admin',
            'member'
        ];
        if (!in_array($role, $available_role)) {
            return false;
        }
        return true;
    }

    public function public_path()
    {
        return base_path('public/');
    }

    public function upload($file_request, $disk)
    {
        $file = $this->request->file($file_request);
        $extension = $file->getClientOriginalExtension();
        $icon = Uuid::uuid4()->toString() . '.' . $extension;
        $storage_path = storage_path($disk);
        $icon_name = $storage_path . '/' . $icon;
        $file->move($storage_path, $icon_name);
        return $icon;
    }

    public function is_valid_decode_json($json_field = [])
    {
        foreach ($json_field as $key => $data) {
            if ($data === null || !is_array($data)) {
                return [
                    'success' => false,
                    'index' => $key
                ];
            }
        }
        return [
            'success' => true,
            'index' => 0
        ];
    }
}
