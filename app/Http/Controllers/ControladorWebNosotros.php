<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Entidades\Postulacion;



require app_path() . '/start/constants.php';
class ControladorWebNosotros extends Controller
{
    public function index()
    {

        return view('web.nosotros');
    }
      
    public function postular(Request $request)
    {
        try {
            //Define la entidad servicio
            if ($request->hasFile('txtAdjuntoCv')) {
                $file = $request->file('txtAdjuntoCv');
                $cv = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/curriculum/', $cv);
            }

            $entidad = new Postulacion();
            $entidad->cargarDesdeRequest($request);
            $mensaje = "Gracias ".$entidad->nombre.", pronto estarás recibiendo noticias nuestras!";
            $entidad->adjunto_cv = $cv;
            $entidad->msj = $mensaje;


            //Es nuevo
            $entidad->insertar(); //insert de postulacion
            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = OKINSERT;

            $id = $entidad->idpostulante;
            $postulante= new Postulacion();
            $aPostulaciones = $postulante->obtenerPorId($id);

            $_POST["id"] = $entidad->idpostulante;
            return view('web.mensaje_postulacion', compact('postulante')). '?id=' . $postulante->idpostulacion;
            
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
       // $id = $entidad->idpostulante;
        //$postulacion = new Postulacion();
        //$aPostulaciones = $postulacion->obtenerPorId($id);

       // return view('postulacion.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;
    }
}
?>