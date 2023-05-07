<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function adminLogin()
    {
        $campuses = Campus::all();
        return view('auth.login', compact('campuses'));
    }

    public function redirectToGoogle(Request $request)
    {
        Validator::make(
            $request->all(),
            ['campus_code' => ['required'],],
            ['campus_code.required' => 'Vui lòng chọn cơ sở'],
        )->validate();
        Session::put('campus_code', $request->campus_code);
        return Socialite::driver('google')->redirect();
    }

    public function adminGoogleCallback()
    {
        Session::forget('token');
//        $ggUser = Socialite::driver('google')->user();
        $ggUser = Socialite::driver('google')->stateless()->user();
//        dd($ggUser);
//        dd(Session::all());
//        dd(1);
        $user = User::where('email', $ggUser->email)->where('campus_code', session('campus_code'))->first();
        // dd($user->hasRole(config('util.ADMIN_ROLE')));
        if ($user && $user->hasRole([config('util.SUPER_ADMIN_ROLE'), config('util.ADMIN_ROLE'), config('util.JUDGE_ROLE'), config('util.TEACHER_ROLE')])) {
            Auth::login($user);
            if (!session()->has('token')) {
                auth()->user()->tokens()->delete();
                $token = auth()->user()->createToken("token_admin")->plainTextToken;
                session()->put('token', $token);
            }
            return redirect(route('dashboard'));
        }
        return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
    }

    public function postLoginToken(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->userFromToken($request->token);
        } catch (Exception $ex) {
            Log::info("=================================");
            Log::error("Lỗi đăng nhập: " . $ex->getMessage());
            Log::error("Token: " . $request->token);
            log::info("=================================");

            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại",
            ]);
        }
        // if (!Str::contains($googleUser->email, config('util.END_EMAIL_FPT'))) return response()->json([
        //     'status' => false,
        //     'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại",
        // ]);

        $user = User::with(['roles', 'campus'])->where('email', $googleUser->email)->first();
        if ($user && $user->campus_code === $request->campus_code) {
            if ($user->status == 0) return response()->json(
                [
                    'status' => false,
                    'payload' => "Xác thực thất bại",
                ]
            );
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    "token" => $token,
                    "token_type" => 'Bearer',
                    'user' => $user->toArray(),
                ],
            ]);
        }
        $flagRoleAdmin = false;
        $MSSV = null;
        $campus_code = null;
        if (strlen($googleUser->email) < 8) $flagRoleAdmin = true;
        if (!$flagRoleAdmin) foreach (config('util.MS_SV') as $ks) {
            $MSSV = \Str::lower($request->campus_code) . \Str::afterLast(
                    \Str::of($googleUser->email)
                        ->before(config('util.END_EMAIL_FPT'))
                        ->toString(),
                    \Str::lower($ks)
                );
            $campus_code = \Str::lower($request->campus_code);
        }
//        return $campus_code;
        try {
            $user = null;
            DB::transaction(function () use ($MSSV, $googleUser, &$user, $campus_code) {
                $user = User::create([
                    'mssv' => $MSSV,
                    'name' => $googleUser->name ?? 'no name',
                    'email' => $googleUser->email,
                    'status' => 1,
                    'avatar' => null,
                    'campus_code' => $campus_code,
                ]);
            });
            $user->load('campus');
            if ($flagRoleAdmin && $user) $user->assignRole('admin');
            if (!$flagRoleAdmin && $user) $user->assignRole('student');
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    "token" => $token,
                    "token_type" => 'Bearer',
                    'user' => $user->toArray(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'payload' => "Xác thực thất bại",
            ]);
        }
    }

    public function fake_login(Request $request)
    {
        $user = User::with('roles')->where('email', $request->email)->first();
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    'token' => $token,
                    'user' => $user->toArray(),
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'payload' => "email không tồn tại",
        ]);
    }

    public function logout()
    {
        if (auth()->check() == false) return redirect(route('login'));
        auth()->user()->tokens()->delete();
        Auth::logout();
        return redirect(route('login'));
    }
}
