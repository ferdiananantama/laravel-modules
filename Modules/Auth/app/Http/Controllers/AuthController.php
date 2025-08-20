<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth::index');
    }

    public function processLogin(Request $request)
    {
        $nik = $request->input('nik');
        $password = $request->input('password');

        $encryptedNik = self::enkripsi($nik);

        $url = 'http://192.168.100.190/api/login.php?n=' . $encryptedNik;
        $response = @file_get_contents($url);
        $data = json_decode($response, true);

        if ($data && isset($data['status']) && $data['status'] === 'success') {
            session(['user' => $data['user']]);
            return redirect()->route('admin.monitoring.index');
        }

        return back()->withErrors(['login' => 'NIK atau Password salah']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('login');
    }

    // 🔐 fungsi enkripsi (copy dari sebelumnya)
    public static function enkripsi($input, $shift = 8)
    {
        $output = '';

        for ($i = 0; $i < strlen($input); $i++) {
            $temp = ord($input[$i]);
            $temp = $temp - $shift;
            $temp = chr($temp);
            $output = $output . $temp;
        }

        $str1 = substr($output, 0, 1);
        $str2 = substr($output, 1, 999999);
        $str = $str1 . mt_rand(100000, 999999) . $str2;
        $str = rand(1111, 9999) . date('y') . $str . date('m') . rand(10101, 99999);
        $str = base64_encode($str);

        return $str;
    }
}
