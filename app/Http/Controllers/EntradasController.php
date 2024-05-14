<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Usuario;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use TCPDF;

class EntradasController extends Controller
{
    public function listado($page = 0)
    {
        $offset = $page * 3;
        $entradas = Entrada::with('categoria', 'usuario')
            ->skip($offset)
            ->orderBy('fecha', 'desc')
            ->take(3)
            ->get();
        $numFilas = Entrada::count();
        return view('entradas.index', [
            'entradas' => $entradas,
            'page' => $page,
            'contador' => $numFilas,
            'offset' => $offset
        ]);
    }

    public function guardarEntrada(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'lugar' => 'required',
            'prioridad' => 'required|integer',
            'estado' => 'required'
        ]);

        if (Auth::check()) { // Verificar si hay un usuario autenticado
            $entrada = new Entrada;
            $entrada->titulo = $request->titulo;
            $entrada->categoria_id = $request->categoria;
            $entrada->usuario_id = Auth::id(); // Obtener el ID del usuario autenticado
            $entrada->descripcion = $request->descripcion;
            $entrada->fecha = $request->fecha;
            $entrada->hora = $request->hora;
            $entrada->lugar = $request->lugar;
            $entrada->prioridad = $request->prioridad;
            $entrada->estado = $request->estado;

            if ($imagen = $request->imagen) {
                $nombreFichImg = time() . "-" . $imagen->getClientOriginalName();
                Storage::putFileAs('public/images', $imagen, $nombreFichImg);
                Storage::setVisibility($nombreFichImg, 'public');
                $entrada->imagen = $nombreFichImg;
            } else {
                $entrada->imagen = "----";
            }

            $log = new Log;
            $log->usuario = Auth::user()->nick; // Obtener el nick del usuario autenticado
            $log->operacion = "Nueva entrada";
            $log->save();

            $entrada->save();
            return redirect()->route('entradas', [0])->with('success', 'Entrada creada correctamente');
        } else {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear una entrada');
        }
    }

    public function crearEntrada()
    {
        $categorias = Categoria::all();
        return view('entradas.crear', ['categorias' => $categorias]);
    }

    public function detalle($id = -1)
    {
        if ($id != -1) {
            $detalles = Entrada::with('categoria', 'usuario')->where('id', $id)->get();
            return view('entradas.detalle', ['detalles' => $detalles]);
        } else {
            return redirect()->route('entradas', [0]);
        }
    }

    public function eliminar($id = -1)
    {
        if ($id != -1) {
            $detalles = Entrada::with('categoria', 'usuario')->where('id', $id)->get();
            return view('entradas.eliminar', ['detalles' => $detalles]);
        } else {
            return redirect()->route('entradas', [0]);
        }
    }

    public function borrar($id = -1)
    {
        if ($id != -1) {
            Entrada::where('id', $id)->delete();
            $log = new Log;
            $log->usuario = Auth::user()->nick;
            $log->operacion = "Entrada Eliminada";
            $log->save();
        }
        return redirect()->route('entradas', [0])->with('eliminado', 'Entrada eliminada');
    }

    public function edicion($id = -1)
    {
        if ($id != -1) {
            $categorias = Categoria::all();
            $detalles = Entrada::with('categoria', 'usuario')->where('id', $id)->get();
            return view('entradas.editar', ['detalles' => $detalles, 'categorias' => $categorias]);
        } else {
            return redirect()->route('entradas', [0]);
        }
    }

    public function editar($id = -1, Request $request)
    {
        if ($id != -1) {
            $entrada = Entrada::find($id);
            $entrada->titulo = $request->titulo;
            $entrada->categoria_id = $request->categoria;
            $entrada->usuario_id = $request->usuario_id;
            $entrada->descripcion = $request->descripcion;
            $entrada->fecha = $request->fecha;
            $entrada->hora = $request->hora;
            $entrada->lugar = $request->lugar;
            $entrada->prioridad = $request->prioridad;
            $entrada->estado = $request->estado;

            if ($imagen = $request->imagen) {
                $nombreFichImg = time() . "-" . $imagen->getClientOriginalName();
                Storage::putFileAs('public/images', $imagen, $nombreFichImg);
                Storage::setVisibility($nombreFichImg, 'public');
                $entrada->imagen = $nombreFichImg;
            } else {
                $entrada->imagen = "----";
            }

            $log = new Log;
            $log->usuario = Auth::user()->nick;
            $log->operacion = "Edición entrada";
            $log->save();

            $entrada->save();
            return redirect()->route('entradas', [0])->with('success', 'Entrada editada correctamente');
        } else {
            return redirect()->route('entradas', [0]);
        }
    }

    public function generarPDF()
    {
        // Obtener todas las entradas con las relaciones cargadas
        $entradas = Entrada::with('categoria', 'usuario')->get();

        // Crea una nueva instancia de TCPDF
        $pdf = new TCPDF();

        // Establece el título del documento
        $pdf->SetTitle('Listado de Entradas');

        // Agrega una página al documento
        $pdf->AddPage();

        // Establece el contenido del PDF
        $pdf->SetFont('helvetica', '', 12);
        foreach ($entradas as $entrada) {
            $pdf->Cell(0, 10, 'Título: ' . $entrada->titulo, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Descripción: ' . $entrada->descripcion, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Categoría: ' . $entrada->categoria->nombre, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Usuario: ' . $entrada->usuario->nick, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Fecha: ' . $entrada->fecha, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Hora: ' . $entrada->hora, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Lugar: ' . $entrada->lugar, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Prioridad: ' . $entrada->prioridad, 0, 1, 'L');
            $pdf->Cell(0, 10, 'Estado: ' . $entrada->estado, 0, 1, 'L');
            $pdf->Ln(5); // Agrega un salto de línea
        }

        // Genera la salida del PDF
        $pdfContent = $pdf->Output('listado_entradas.pdf', 'S');

        // Retorna la respuesta con el contenido del PDF
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf');
    }
}
