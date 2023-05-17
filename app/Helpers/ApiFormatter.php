<?php
// fungsi file ini untuk mengatur hasil API yang akan ditampilkan-->$_COOKIE
// file ini mengatur proses pengambilan API 
// namespace : untuk mengatur posisi file ada di folder mana
namespace App\Helpers;
use Exception;

class ApiFormatter{
    // variable yg akan dihasilkan ketika API digunakan
    protected static $response = [
        'code' => NULL,
        'message' => NULL,
        'data' => NULL,
    ];

    public static function createAPI($code = NULL, $message = NULL, $data = NULL)
    {
        // mengisi data ke variabel $response yang diatas
        self::$response['code'] = $code;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        // mengembalikan hasil pengisian data $response dengan format json
        return response()->json(self::$response, self::$response['code']);
    }
}