<?php

namespace App\Http\Controllers;

use App\Entidades\Postulacion; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller
{
    public function nuevo()
    {

        $titulo = "Postulaciones";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEALTA")) {
                $codigo = "POSTULANTEALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $usuarios = new Usuario();
                $array_usuarios = $usuarios->obtenerTodos();

                return view('postulacion.postulacion-nuevo', compact('titulo', 'array_usuarios'));
            }
        } else {
            return view('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Postulacion";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTECONSULTA")) {
                $codigo = "POSTULANTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('postulacion.postulacion-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function editar($id)
    {
        $titulo = "Modificar postulación";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEEDITAR")) {
                $codigo = "POSTULANTEEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {

                $postulacion = new Postulacion();
                $postulacion->obtenerPorId($id);


                $usuarios = new Usuario();
                $array_usuarios = $usuarios->obtenerTodos();

                return view('postulacion.postulacion-nuevo', compact('postulacion', 'titulo', 'array_usuarios'));
            }
        } else {
            return redirect('admin/login');
        }
    }


    public function eliminar(Request $request)
    {

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("POSTULANTEBAJA")) {
                
                $entidad = new Postulacion();
                $entidad->cargarDesdeRequest($request);

                $entidad->eliminar();
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "POSTULANTEBAJA";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;
       
        $entidadPostulacion = new Postulacion();
        $aPostulaciones = $entidadPostulacion->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aPostulaciones) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = $aPostulaciones[$i]->nombre;
            $row[] = $aPostulaciones[$i]->apellido;
            $row[] = $aPostulaciones[$i]->correo;
            $row[] = $aPostulaciones[$i]->whatsapp;
           // $row[] = $aPostulaciones[$i]->adjunto_cv;
            $row[] = '<a href="/curriculum/'.$aPostulaciones[$i]->adjunto_cv.'"> Descargar adjunto </a>';
            $row[] = '<a href="/admin/postulacion/nuevo/' . $aPostulaciones[$i]->idpostulante . '">' . '<i class="fas fa-eye"></i></a>';
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }


    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            if ($request->hasFile('txtAdjuntoCv')) {
                $file = $request->file('txtAdjuntoCv');
                $cv = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/imagenes/', $cv);
            }

            $titulo = "Modificar postula";
            $entidad = new Postulacion();
            $entidad->cargarDesdeRequest($request);
            // $entidad->titulo = $request->input('txtTitulo');
            // $entidad->descripcion = $request->input('txtDescripcion');
            // $entidad->precio = $request->input('txtPrecio');
            $entidad->adjunto_cv = $cv;


            //validaciones
            if ($entidad->titulo == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar(); //update de postulacion
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar(); //insert de postulacion
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }


                $_POST["id"] = $entidad->idpostulacion;
                return view('postulacion.postulacion-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        $id = $entidad->idpostulacion;
        $postulacion = new Postulacion();
        $aPostulaciones = $postulacion->obtenerPorId($id);

        return view('postulacion.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;
    }
}
