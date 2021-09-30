<?php

namespace App\Http\Controllers;

use App\Entidades\Producto; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use DB;
use Illuminate\Http\Request;
use Session;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{
    public function index()
    {
        $titulo = "Productos";
     
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) {
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.producto-listar', compact('titulo'));
            }
        
    }


    public function nuevo()
    {   
        $titulo = "Nuevo producto";

            if (!Patente::autorizarOperacion("PRODUCTOSALTA")) {
                $codigo = "PRODUCTOSALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
               
                return view('producto.producto-nuevo', compact('titulo'));
            }
        
    }

    public function editar($id)
    {
        $titulo = "Modificar producto";
        
            if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
                $codigo = "PRODUCTOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {

                $producto = new Producto();
                $producto->obtenerPorId($id);  

                return view('producto.producto-nuevo', compact('producto', 'titulo'));
            }

    }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            if($request->hasFile('txtImagen')){
                $file = $request->file('txtImagen');
                $img = time().$file->getClientOriginalName();
                $file->move(public_path(). '/imagenes/', $img);
                               
            }

            $titulo = "Modificar Producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);
            // $entidad->titulo = $request->input('txtTitulo');
            // $entidad->descripcion = $request->input('txtDescripcion');
            // $entidad->precio = $request->input('txtPrecio');
            $entidad->imagen = $img;
           

            //validaciones
            if ($entidad->titulo == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();//update de producto
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();//insert de producto
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

                $_POST["id"] = $entidad->idproducto;
                return view('producto.producto-listar', compact('titulo', 'msg'));
                }
        }catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }
    $id = $entidad->idproducto;
        $producto = new Producto();
        $aProductos = $producto->obtenerPorId($id);

        return view('producto.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;

}

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

            if (Patente::autorizarOperacion("PRODUCTOELIMINAR")) {
               
                $entidad = new Producto();
                $entidad->cargarDesdeRequest($request);

                $entidad->eliminar();
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "PRODUCTOELIMINAR";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadProducto = new Producto();
        $aProductos = $entidadProducto->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aProductos) > 0) {
            $cont = 0;
        }

        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<img class="img-thumbnail" width="150px" height="130px" src="/imagenes/'.$aProductos[$i]->imagen.'">';
            $row[] = $aProductos[$i]->titulo;
            $row[] = $aProductos[$i]->descripcion;
            $row[] = $aProductos[$i]->precio;
      
            $row[] = '<a href="/admin/producto/nuevo/' . $aProductos[$i]->idproducto . '">' . '<i class="fas fa-edit"></i></a>';
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}

