<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;


use Illuminate\Support\Facades\Http;

class CadastroController extends Controller
{
    public function create() {
        return view('cadastro');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'data_nascimento' => 'required|date',
            'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
        ]);

        if ($request->id) {
            $cadastro = Cadastro::find($request->id);
            $cadastro->update($request->all());
            return redirect()->back()->with('success', 'Cadastro atualizado com sucesso.');
        } else {
            Cadastro::create($request->all());
            return redirect()->back()->with('success', 'Cadastro realizado com sucesso.');
        }
    }

    public function edit($id)
    {
        $cadastro = Cadastro::find($id);
        return view('cadastro', compact('cadastro'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'data_nascimento' => 'required|date',
            'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
        ]);

        $cadastro = Cadastro::find($id);
        $cadastro->update($request->all());

        return redirect()->back()->with('success', 'Cadastro atualizado com sucesso.');
    }

    public function delete($id)
    {
        $cadastro = Cadastro::find($id);
        $cadastro->delete();

        return redirect()->route('cadastro.create')->with('success', 'Cadastro excluído com sucesso.');
    }

    public function search(Request $request)
    {
        $id = $request->input('search_id');
        $cadastro = Cadastro::find($id);
        if ($cadastro) {
            return view('cadastro', compact('cadastro'));
        } else {
            return redirect()->back()->with('error', 'Cadastro não encontrado.');
        }
    }   

    public function buscarCep($cep)
    {
        $response = Http::withOptions(['verify' => false])->get("https://viacep.com.br/ws/{$cep}/json/");
        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'CEP não encontrado'], 404);
        }
    }
}