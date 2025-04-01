<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalistController extends Controller
{
    public function register(Request $request)
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:journalists',
            'senha' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Criar o jornalista
        $journalist = Journalist::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
        ]);

        return response()->json(['message' => 'Jornalista registrado com sucesso!', 'journalist' => $journalist], 201);
    }
}
