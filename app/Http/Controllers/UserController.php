<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // Registro de usuário
    public function register(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Usuário registrado com sucesso!'
        ], 201);
    }
    // Login 
    public function login(Request $request)
    {
        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login realizado com sucesso!'
            ]);
        }
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    // Logout 
    public function logout(Request $request)
    {   
        
        // echo '<pre>'.print_r($request->user()->currentAccessToken()).'</pre>';
        // die();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }



    public function showRegisterForm()
    {
        return view('auth.register');
    }
    // Método para exibir o formulário de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Obter dados do usuário logado
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // Editar usuário
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update($request->only(['name', 'email']));
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json([
            'user' => $user,
            'message' => 'Usuário atualizado com sucesso!'
        ]);
    }

    // Deletar usuário 
    public function destroy(Request $request)
    {
        $request->user()->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso!']);
    }
}
