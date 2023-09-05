<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Resources\LoginResource as CollectionUser;
use Exception;
use Illuminate\Support\Facades\DB;

class TokensController extends Controller
{

    public function login(Request $request)
    {
        $credencials = $request->only('email', 'password');

        # Valida las credenciales del usuario
        $validator = Validator::make($credencials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['sMensaje' => 'Ingreso un usuario y password incorrecto.', "sCodigo" => 0], 406);
        }

        # Aqui optenemos datos del usuario a logearse, ya vericando que sus credenciales sean correctas
        $usuario = User::where('email', $credencials['email'])->first();

        $usuario = DB::table('tb_users')
            ->select(
                'tb_users.user_id',
                'tb_users.user_code',
                'tb_users.user_name',
                'tb_users.user_firstname',
                'tb_users.user_lastname',
                'tb_users.user_email',
                'tb_users.user_telefono',
                'tb_users.user_check_origen',
                'tb_users.user_check_dealer',
                'tb_users.user_role_id',
                'tb_users.user_status_id'
            )
            ->orderBy('tb_users.user_firstname', 'ASC')
            ->where('user_id',$usuario->user_id)
            ->first();
        if (!$usuario) {
            return response()->json(['sMensaje' => "El usuario no existe.", "sCodigo" => 0], 406);
        }

        if ($usuario->user_status_id == 74) {
            return response()->json(['sMensaje' => "El usuario esta inactivo.", "sCodigo" => 0], 404);
        }

        # Genera el token con una duracion 24 horas (1 Dia).
        $token = JWTAuth::attempt($credencials, ['exp' => Carbon::now()->addDays(1)->timestamp]);

        # Si hay token valido entonces se muestra una respuesta
        if ($token) {
                return response()->json([
                    'stoken' => $token,
                    'sExpirate' => '24 hrs',
                ], 200);
        } else {
            return response()->json([
                'sStatus' => "406",
                'sMessage6' => 'Ingreso un usuario y password incorrecto'
            ], 406);
        }

        return null;
    }

    public function refresToken()
    {
        $token = JWTAuth::getToken();
        try {
            $token = JWTAuth::refresh($token);
            return response()->json(['sMessage5' => 'Token ha sido refrescado', 'sToken' => $token], 201);
        } catch (TokenExpiredException $ex) {
            return response()->json(['sMessage4' => $ex->getMessage()], 406);
        } catch (TokenBlacklistedException $ex) {
            return response()->json(['sMessage3' => $ex->getMessage()], 406);
        }
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        auth()->logout();
        try {
            JWTAuth::invalidate();
            return response()->json(['Mensaje' => 'Se cerro sesion'], 200);
        } catch (JWTException $ex) {
            return response()->json(['Mensaje' => $ex->getMessage()], 401);
        }
    }
}
