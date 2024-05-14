<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Entrada;
use App\Models\Usuario;
use App\Models\Categoria;

class Controlador extends Controller
{
    private $entrada;
    private $usuario;
    private $categoria;

    public function __construct()
    {
        $this->entrada = new Entrada();
        $this->usuario = new Usuario();
        $this->categoria = new Categoria();
    }

    public function index()
    {
        return view('login', ["titulo" => "MVC"]);
    }
    
    public function login(Request $request)
    {
        $usuario = $request->input('txtusuario');
        $password = $request->input('pass');

        // Llamar al método comprobarUser() con los argumentos adecuados
        $result = $this->usuario->comprobarUser($usuario, $password);

        if ($result) {
            // Usuario y contraseña válidos, redirigir a la página de listado
            return redirect()->route('listado');
        } else {
            // Usuario o contraseña inválidos, volver a la página de inicio de sesión
            return view('login', ["titulo" => "login"]);
        }
    }

    public function registrar(Request $request)
    {
        try {
            $request->validate([
                'nick' => 'required|string|max:32',
                'nombre' => 'required|string|max:32',
                'apellidos' => 'required|string|max:32',
                'email' => 'required|email|unique:usuarios',
                'password' => 'required|string|min:6',
                'imagen-avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Lógica para almacenar el usuario en la base de datos
            $usuario = new Usuario();
            $usuario->nick = $request->nick;
            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->imagen_avatar = $request->file('imagen-avatar')->store('avatars');
            $usuario->tipo = 0; // Usuario normal por defecto
            $usuario->save();

            // Redirección exitosa
            return redirect('/login')->with('success', 'Usuario registrado correctamente. Por favor, inicia sesión.');

        } catch (ValidationException $e) {
            // Captura de errores de validación
            return redirect('/registro')->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Captura de errores genéricos
            return redirect('/registro')->with('error', 'Ha ocurrido un error al registrar el usuario. Por favor, inténtalo de nuevo.');
        }
    }

    public function mostrarFormularioRegistro()
    {
        return view('registro');
    }

    public function listado()
    {
        $datos = $this->entrada->listado()->orderBy('fecha', 'asc')->get();
        return view('listado', ["titulo" => "Listado", "datos" => $datos]);
    }    

    public function nuevaEntrada(Request $request)
    {
        if ($request->session()->has('logueado')) {
            $errores = array();
            $imagen = null;
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $imagen = $request->imagen->store('fotos');
            }

            if (count($errores) == 0) {
                $resultEntrada = $this->entrada->nuevaEntrada([
                    "titulo" => $request->titulo,
                    "descripcion" => $request->descripcion,
                    "usuario_id" => $request->session()->get('user_id'),
                    "categoria_id" => $request->categoria,
                    "imagen" => $imagen,
                    "fecha" => now()->format('d/m/Y')
                ]);

                $resultEntrada = $this->entrada->registrarLog([
                    "usuario" => $request->session()->get('nick'),
                    "operacion" => "Entrada"
                ]);
            }
            return redirect()->route('listado');
        } else {
            return redirect()->route('index');
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('logeado')) {
            $request->session()->flush();
        }
        return redirect()->route('index');
    }

    public function mostrarLog(Request $request)
    {
        $datos = $this->entrada->mostrarLog();
        return view('logs', ["titulo" => "Logs", "datos" => $datos]);
    }

    public function entrada(Request $request)
    {
        if ($request->session()->has('logueado')) {
            $datos = $request->id;
            $resultEntrada = $this->entrada->entrada($datos);
            if ($resultEntrada['bool']) {
                return view('verEntrada', ["titulo" => "Logs", "datos" => $resultEntrada['datos']]);
            }
        }
        return redirect()->route('index');
    }

    public function eliminar(Request $request)
    {
        $id_entrada = $request->id;
        $resultEntrada = $this->entrada->delEntrada($id_entrada);
        $resultEntrada = $this->entrada->registrarLog([
            "usuario" => $request->session()->get('nick'),
            "operacion" => "Eliminar"
        ]);
        return redirect()->route('listado');
    }

    public function editar(Request $request)
    {
        $errores = array();
        $imagen = null;

        if ($request->has('submit')) {
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $imagen = $request->imagen->store('fotos');
            } else {
                $imagen = $request->imagen_actual;
            }

            if (count($errores) == 0) {
                $resultEntrada = $this->entrada->editar([
                    "titulo" => $request->titulo,
                    "descripcion" => $request->descripcion,
                    "categoria_id" => $request->categoria,
                    "imagen" => $imagen,
                    "id" => $request->id
                ]);

                $resultEntrada = $this->entrada->registrarLog([
                    "usuario" => $request->session()->get('nick'),
                    "operacion" => "Edicion"
                ]);

                if ($resultEntrada['bool']) {
                    return redirect()->route('listado');
                } else {
                    return back()->withInput()->withErrors(['mensaje' => 'Error al editar la entrada. Por favor, inténtalo de nuevo.']);
                }
            }
        }

        if ($request->session()->has('logueado')) {
            $datos = $request->id;
            $resultEntrada = $this->entrada->entrada($datos);
            if ($resultEntrada['bool']) {
                $resultCategoria = $this->categoria->idCat();
                $idCat['datos'] = $resultCategoria['datos'];
                return view('editarEntrada', ["titulo" => "Editar Entrada", "datos" => $resultEntrada['datos'], "idCat" => $idCat]);
            }
        }
        return redirect()->route('index');
    }

    public function generarPDF()
    {
        $datos = $this->entrada->listado();
        $entradas = $datos['datos'];
    
        // Incluir la clase TCPDF
        require_once('vendor/tecnickcom/tcpdf/tcpdf.php');
    
        // Crear una nueva instancia de TCPDF
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
        // Establecer información del documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Autor');
        $pdf->SetTitle('Listado de Entradas');
        $pdf->SetSubject('Listado de Entradas');
        $pdf->SetKeywords('TCPDF, PDF, ejemplo, listado, entradas');
    
        // Establecer márgenes
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
        // Establecer el modo de fuente
        $pdf->SetFont('helvetica', '', 10);
    
        // Agregar una página
        $pdf->AddPage();
    
        // Título
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Listado de Entradas', 0, 1, 'C');
    
        // Contenido
        foreach ($entradas as $entrada) {
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, 'Título: ' . $entrada['titulo'], 0, 1);
            $pdf->Cell(0, 10, 'Descripción: ' . $entrada['descripcion'], 0, 1);
            $pdf->Cell(0, 10, 'Autor: ' . $entrada['nick'], 0, 1); // Ajusta según tus datos
            $pdf->Cell(0, 10, 'Categoría: ' . $entrada['categoria_id'], 0, 1); // Ajusta según tus datos
            $pdf->Cell(0, 10, 'Fecha de Creación: ' . $entrada['fecha'], 0, 1);
    
            // Agregar la imagen al PDF
            if (!empty($entrada['imagen'])) {
                $pdf->Image('public/fotos/' . $entrada['imagen'], 15, '', 180, 160, '', '', '', false, 300, '', false, false, 0);
            }
    
            // Agregar espacio entre entradas
            $pdf->Ln();
        }
    
        // Cerrar y generar PDF
        $pdf->Output('listado_entradas.pdf', 'I');
        exit;
    }    
}