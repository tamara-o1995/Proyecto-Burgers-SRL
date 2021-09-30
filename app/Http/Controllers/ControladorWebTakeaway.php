<?php

namespace App\Http\Controllers;


use App\Entidades\Carrito;
use App\Entidades\Cliente;
use App\Entidades\Producto;
use App\Entidades\Pedido;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Session;
  
require app_path() . '/start/constants.php';

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
        $producto = new Producto();
        $array_productos = $producto->obtenerTodos();
        return view('web.takeaway', compact('array_productos'));

    }

    public function agregar(Request $request){

        try {
            $data = $request->all();

            //traemos el cliente con el numero de usuario de la sesion iniciada
            $usuario = new Cliente();
            $cliente = $usuario->obtenerClientePorUsuario(Session::get("usuario_id"));

            $titulo = "Modificar Producto";
            $entidad = new Carrito();
            
            if( $request->input('txtCantidad') == null){
                $entidad->cantidad = 1;
            }else{
                $entidad->cantidad = $request->input('txtCantidad');
            }
            
            $entidad->fk_idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
            $entidad->fk_idcliente = $cliente->idcliente;

 
            
     

            //validaciones
            if ($_POST["id"] > 0) {
                //Es actualizacion
                $entidad->insertar( );//insert de producto
                //$entidad->guardar();//update de producto
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            } else {
                //Es nuevo
               
                $entidad->insertar();//insert de producto
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            }

            
            $_POST["id"] = $entidad->idproducto;
            $producto = new Producto();
            $array_productos = $producto->obtenerTodos();

         
            return redirect()->to('takeaway')->send();

           
                
        }catch (Exception $e) {
        
            $msg["ESTADO"] = MSG_ERROR;
       
            $msg["MSG"] = ERRORINSERT;
    }
    // $id = $entidad->fk_idproducto;
    // $producto = new Producto();
    // $aProductos = $producto->obtenerPorId($id);

        //return view('producto.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;

    
            

        
    }

  


}


