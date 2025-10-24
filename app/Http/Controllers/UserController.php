<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
      // Formulário de registro (view Blade)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registro de usuário
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.form')
            ->with('message', 'Usuário registrado com sucesso! Faça login.');
    }

    // Formulário de login (view Blade)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login (sessão + geração de token Sanctum)
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Gera ou reutiliza token Sanctum
            $token = $user->tokens()->first()?->plainTextToken
                ?? $user->createToken('default', ['product:view', 'product:manage'])->plainTextToken;

            return redirect()->intended('/')
                ->with('success', 'Login realizado com sucesso!')
                ->with('token', $token);
        }

        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Remove o token ativo (opcional, mantém os outros)
            $user->tokens()->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Logout realizado com sucesso!');
    }

    // Endpoint de API para login e emissão de token (sem sessão)
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        // Gera token específico para API
        $token = $user->createToken($request->device_name, ['product:view', 'product:manage'])->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}







    // Registro de usuário
   
    // public function showRegisterForm()
    // {
    //     return view('auth.register');
    // }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }

    //     User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return redirect()->route('login.form')->with('message', 'Usuário registrado com sucesso! Faça login.');
    // }

    // public function showLoginForm()
    // {
    //     return view('auth.login');
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate(); // protege contra fixação de sessão
    //         return redirect()->intended('/')->with('success', 'Login realizado com sucesso!');
    //     }

    //     return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('login.form')->with('message', 'Logout realizado com sucesso!');
    // }

    // // Obter dados do usuário logado
    // public function user(Request $request)
    // {
    //     return response()->json($request->user());
    // }

    // // Editar usuário
    // public function update(Request $request)
    // {
    //     $user = $request->user();

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'sometimes|string|max:255',
    //         'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'sometimes|string|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     $user->update($request->only(['name', 'email']));
    //     if ($request->password) {
    //         $user->password = Hash::make($request->password);
    //         $user->save();
    //     }

    //     return response()->json([
    //         'user' => $user,
    //         'message' => 'Usuário atualizado com sucesso!'
    //     ]);
    // }

    // // Deletar usuário 
    // public function destroy(Request $request)
    // {
    //     $request->user()->delete();
    //     return response()->json(['message' => 'Usuário deletado com sucesso!']);
    // }

