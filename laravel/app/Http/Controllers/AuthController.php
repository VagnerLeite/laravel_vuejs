<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{ 
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
  
    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        
        $regras = [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
        ];

        $messages = [
            'name.required'      => 'Digite o seu nome!',
            'email.required'     => 'Digite seu email!',
            'email.email'        => 'Digite um endereço de email valido!',
            'email.unique:users' => 'Email ja cadastrado!',
            'email.required'     => 'Digite seu email!',
            'password.required'  => 'Digite sua senha',
            'password.min'     => 'Senha nao pode ser menor do que 6 digitos!',
            'password.confirmed' => 'Confirme a senha corretamente!',
            
        ];
        
        $validate = $request->validate($regras,$messages);
               
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->save();

        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);   

        return $this->respondWithToken($token, $request->email);
    } 

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $request->email);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $email)
    {
        $user = User::select('menuroles as roles')->where('email', '=', $email)->first();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'roles' => $user->roles,
        ]);
    }
}