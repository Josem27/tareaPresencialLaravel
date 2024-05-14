<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class UsuariosController extends Controller
{
    public function registro(){
        return view('usuarios.registro');
    }

    public function guardarRegistro(Request $request){

        $request->validate([
            'nick' => 'required',
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
    
        // Busca si ya existe un usuario con el mismo nick
        $existe = Usuario::where('nick', $request->nick)->exists();
    
        if(!$existe){
            // Crea un nuevo usuario
            $registro = new Usuario;
            $registro->nick = $request->nick;
            $registro->nombre = $request->nombre;
            $registro->apellidos = $request->apellidos;
            $registro->email = $request->email;
            $registro->password = bcrypt($request->password); // Utiliza bcrypt para encriptar la contraseña
            $registro->esAdmin = false;
            $registro->save();
    
            // Registra el evento en el log
            $log = new Log;
            $log->usuario = $registro->nick;
            $log->operacion = "Registro";
            $log->save();
    
            return redirect()->route('login')->with('success','Usuario registrado correctamente');
        }else{
            return redirect()->route('registro')->with('invalido','Nombre de usuario en uso');
        }                
    }
    

    public function login(Request $request){
        // Intenta autenticar al usuario con las credenciales proporcionadas
        if (Auth::attempt(['nick' => $request->usuario, 'password' => $request->password])) {
            // Si la autenticación es exitosa, redirige al usuario a la página de entradas
            return redirect()->route('entradas', [0]);
        }
        
        // Si la autenticación falla, redirige al usuario de vuelta a la página de inicio de sesión
        return redirect()->route('login')->with('noencontrado','Usuario o contraseña incorrectos');
    }

    public function exportar(){
        // Verifica si el usuario actual está autenticado antes de exportar los usuarios
        if (Auth::check()) {
            $usuarios = Usuario::all();
            return Excel::download($usuarios, 'usuarios.xlsx');
        } else {
            // Si el usuario no está autenticado, redirige a la página de inicio de sesión
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para exportar usuarios');
        }
    }

    public function logout()
    {
         Auth::logout();
         return redirect()->route('login');
    }
        
}