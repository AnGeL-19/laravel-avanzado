<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  
    public function register(Request $request){

        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'second_last_name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:5'
            ]);


            if ($validator->fails()){
                return response()->json($validator->errors());
            }

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'second_last_name' => $request->second_last_name,
                'email' => $request->email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('Mobile-' . Str::uuid()->toString())->plainTextToken;
            $user->api_token = $token;

            DB::commit();

            return self::responseSuccess("Se realizo el registro exitoso", new UserResource($user));

        } catch (\Throwable $th) {
            DB::rollBack();

            return self::responseError("Error al registrar un usuario", $th);
        }

    }

    public function login(Request $request)
    {

        try {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($credentials)){
                return self::responseError("Unauthorized - email or password is incorrect");
            }

            
            $user = User::where('email', $request->email )->firstOrFail();

            $token = $user->createToken('Mobile-' . Str::uuid()->toString())->plainTextToken;
            $user->api_token = $token;

            return self::responseSuccess("Inicio de sesion exitoso", new UserResource($user));

        }catch (\Throwable $th) {
            return self::responseError("Error al iniciar sesion", $th);
        }

    }

    public function logout(Request $request): JsonResponse
    {

        try {
            //code...

            $user= auth('api')->user();

            $token = $request->get('api_token', null);

            $tokenModel = PersonalAccessToken::findToken($token);

            if (!isset($tokenModel) && ($tokenModel->tokenable_id != $user->id) ) {
                return self::responseError("Error al cerrar sesión");
            }

            DB::beginTransaction();

            $tokenModel->delete();

            DB::commit();
            return self::responseSuccess("Cierre de sesión exitoso");

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return self::responseError("Error al cerrar sesión", $th);

        }


    }

}
