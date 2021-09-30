<?php

namespace App\Http\Controllers;


use App\Entidades\Pedido; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Cliente;
use App\Entidades\Pedido_articulo;
use Illuminate\Http\Request;


require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{

    public function index()
    {
        $titulo = "Pedidos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOCONSULTA")) {
                $codigo = "PEDIDOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";

                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pedido.pedido-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function editar($id)
    {
        $titulo = "Modificar pedido";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOEDITAR")) {
                $codigo = "PEDIDOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pedido = new Pedido();
                $pedido->obtenerPorId($id);

                $cliente = new Cliente();
                $array_clientes = $cliente->obtenerTodos();

                $usuarios = new Usuario();
                $array_usuarios = $usuarios->obtenerTodos();

                $producto = new Producto();
                $array_productos = $producto->obtenerTodos();

                // $pedido_estado = new Pedido_estado();
                //$array_pedidos_estados = $pedido_estado->obtenerTodos();

                $sucursal = new Sucursal();
                $array_sucursales = $sucursal->obtenerTodos();

                return view('pedido.pedido-ver', compact('pedido', 'titulo', 'array_clientes', 'array_usuarios', 'array_productos', 'estado', 'array_sucursales'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOBAJA")) {
                $entidad = new Pedido();
                $entidad->cargarDesdeRequest($request);

                $entidad->eliminar();
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente

            } else {
                $codigo = "PEDIDOBAJA";
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

        $entidadPedido = new Pedido();
        $aPedidos = $entidadPedido->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        if (count($aPedidos) > 0) {
            $cont = 0;
        }


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedido/ver/' . $aPedidos[$i]->idpedido . '">' . '<i class="far fa-eye"></i>';
            $row[] = $aPedidos[$i]->idpedido;
            $row[] = $aPedidos[$i]->domicilio;
            $row[] = $aPedidos[$i]->apellido . ', ' . $aPedidos[$i]->nombre;
            $row[] = $aPedidos[$i]->telefono;
            $row[] = $aPedidos[$i]->fecha;
            $row[] = $aPedidos[$i]->total;

            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request)
    {
        //Define la entidad servicio
        $titulo = "Modificar pedido";
        $entidad = new Pedido();
        $entidad->cargarDesdeRequest($request);
        try {
            //validaciones
            // if ($entidad->fecha == "") {
            //     $msg["ESTADO"] = MSG_ERROR;
            //     $msg["MSG"] = "Complete todos los datos";
            // } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    /* $usuario = new Usuario();
                    $usuario->nombre = $request->input("txtNombre");                      
                    $usuario->apellido = $request->input("txtApellido");                      
                    $usuario->correo = $request->input("txtCorreo");                         
                    $usuario->area_predeterminada = Session::get('grupo_id');
                    $clave = str_random(8);
                    $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
                    $usuario->clave = $claveEncriptada; 
                    $usuario->insertar();  */
                    $entidad->insertar();


                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $entidad->idpedido;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            // }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idpedido;
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorId($id);

        return view('pedido.pedido-listar', compact('msg', 'titulo'));
    }

    public function nuevo()
    {
        $titulo = "Nuevo Pedido";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOALTA")) {
                $codigo = "PEDIDOALTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";

                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $usuarios = new Usuario();
                $array_usuarios = $usuarios->obtenerTodos();

                $cliente = new Cliente();
                $array_clientes = $cliente->obtenerTodos();

                $producto = new Producto();
                $array_productos = $producto->obtenerTodos();

                //$pedido_estado = new Pedido_estado();
                //$array_pedidos_estados = $pedido_estado->obtenerTodos();

                $sucursal = new Sucursal();
                $array_sucursales = $sucursal->obtenerTodos();


                return view('pedido.pedido-ver', compact('titulo', 'array_usuarios', 'array_clientes', 'array_productos', 'estado', 'array_sucursales'));
            }
        } else {
            return view('admin/login');
        }
    }

    public function ver($id)
    {
        $titulo = "Pedido N° $id";

        if (!Patente::autorizarOperacion("PEDIDOVER")) {
            $codigo = "PEDIDOVER";
            $mensaje = "No tiene pemisos para la operaci&oacute;n.";
            return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
        } else {

            $pedido = new Pedido();
            $pedido->obtenerPorId($id);
            
            $entidadPedidoArticulo = new Pedido_articulo();
            $aArticulos = $entidadPedidoArticulo->obtenerFiltrado($id);


            return view('pedido.pedido-ver', compact('pedido', 'titulo', 'aArticulos'));
        }
    }

}
