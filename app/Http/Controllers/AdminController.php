<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminFormRequest;
use App\Http\Requests\AdminFormRequestUpdate;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function criarAdmin(AdminFormRequest $request)
    {
        $admin = Administrador::create([
            'name' =>  $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password)

        ]);
        return response()->json([
            "success" => true,
            "message" => "Admin cadastrado com sucesso",
            "data" => $admin
        ], 200);
    }

    public function pesquisarPorId($id)
    {
        $admin = Administrador::find($id);
        if ($admin == null) {
            return response()->json([
                'status' => false,
                'message' => "Admin não encontrado"
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $admin
        ]);
    }


    public function retornarTodos()
    {
        $admin = Administrador::all();
        return response()->json([
            'status' => true,
            'data' => $admin
        ]);
    }

    public function excluirAdmin($id)
    {
        $admin = Administrador::find($id);

        if (!isset($admin)) {
            return response()->json([
                'status' => false,
                'message' => "Admin não encontrado"
            ]);
        }
        $admin->delete();
        return response()->json([
            'status' => true,
            'message' => "Admin excluido com sucesso"
        ]);
    }

    public function atualizarAdmin(AdminFormRequestUpdate $request)
    {
        $admin = Administrador::find($request->id);

        if (!isset($admin)) {
            return response()->json([
                'status' => false,
                'message' => "Admin não encontrado"
            ]);
        }

        if (isset($request->name)) {
            $admin->name = $request->name;
        }

        if (isset($request->email)) {
            $admin->email = $request->email;
        }

        if (isset($request->cpf)) {
            $admin->cpf = $request->cpf;
        }


        $admin->update();

        return response()->json([
            'status' => true,
            'message' => "Admin atualizados"
        ]);
    }

    public function pesquisarPorCpf(Request $request)
    {
        $admin = Administrador::where('cpf', 'like', '%' . $request->cpf . '%')->get();

        if (count($admin) > 0) {

            return response()->json([
                'status' => true,
                'data' => $admin
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Não há resultados para a pesquisa.'
        ]);
    }



    public function esqueciMinhapassword(Request $request)
    {
        $admin = Administrador::where('email','LIKE', $request->email)->first();
        if ($admin) {
            $novapassword = $admin->cpf;
            $admin->update([
                'password' => Hash::make($novapassword),
            ]);
            return response()->json([        
                'status' => true,
                'message' => 'password redefinida',
                'nova_password' => $novapassword
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Administrador não encontrado'
            ]);
        }
    }
    
}