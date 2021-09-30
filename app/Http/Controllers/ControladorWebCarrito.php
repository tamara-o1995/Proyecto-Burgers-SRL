<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Carrito;
use App\Entidades\Cliente;
use App\Entidades\Producto;
use App\Entidades\Pedido;
use App\Entidades\Pedido_articulo;
use App\Entidades\Sucursal;
use Session;


class ControladorWebCarrito extends Controller
{
  
    public function index()
    {

        $carrito = new Carrito();
        $array_carrito = $carrito->obtenerPorUsuario(Session::get("usuario_id"));

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        $total = $this->calcularTotal();
        $subtotal = $this->calcularSubtotal();
        $iva = $this->calcularTotal() - $this->calcularSubtotal();
        $mje = " ";


        return view('web.carrito', compact('array_carrito', 'aSucursales','total', 'subtotal', 'iva', 'mje' ));
        

        

    }

    public function calcularTotal(){
        $total = 0;

        $carrito = new Carrito();
        $array_carrito = $carrito->obtenerPorUsuario(Session::get("usuario_id"));

        //$id = $carrito->fk_idproducto;
        //$producto = new Producto();
        //$aProductos = $producto->obtenerPorId($id);
        foreach ($array_carrito as $producto) {
           $total += $producto->precio * $producto->cantidad; 
        }

        return $total;

    }

    public function calcularSubtotal(){
        
        $subtotal = $this->calcularTotal() - ($this->calcularTotal() * 0.21);
        return $subtotal;
    }



    // public function agregar(Request $request){

    //     try {
            
    //         //traemos el cliente con el numero de usuario de la sesion iniciada
    //         $usuario = new Cliente();
    //         $cliente = $usuario->obtenerClientePorUsuario(Session::get("usuario_id"));

    //         $titulo = "Modificar Producto";
    //         $entidad = new Carrito();
           
    //         $entidad->cargarDesdeRequest($request);
    //         $entidad->cantidad = $request->input('txtCantidad');
          

    //         //validaciones
    //         if ($_POST["id"] > 0) {
    //             //Es actualizacion
    //             $entidad->guardar();//update de producto
    //             $msg["ESTADO"] = MSG_SUCCESS;
    //             $msg["MSG"] = OKINSERT;
    //         } else {
    //             //Es nuevo
    //             $entidad->insertar( $entidad->cantidad, $entidad->fk_idproducto ,$cliente->idcliente );//insert de producto
    //             $msg["ESTADO"] = MSG_SUCCESS;
    //             $msg["MSG"] = OKINSERT;
    //         }

            
    //         $_POST["id"] = $entidad->fk_idproducto;
    //         //return view('web.takeaway', compact('titulo', 'msg'));
    //         return view('producto.producto-listar', compact('titulo', 'msg'));
                
    //     }catch (Exception $e) {
        
    //         $msg["ESTADO"] = MSG_ERROR;
       
    //         $msg["MSG"] = ERRORINSERT;
    //     }
    //     $id = $entidad->idproducto;
    //     $producto = new Producto();
    //     $aProductos = $producto->obtenerPorId($id);

    //     return view('producto.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;

    // }

    public function eliminar(Request $request){

        $carrito = new Carrito;
        // $carrito->cargarDesdeRequest($request);
        $carrito->idcarrito = $request->input('id') != "0" ? $request->input('id') : $this->idcarrito; //CAPTURA EL ID QUE LE LLEGA DEL FORMULARIO (EJ. idcarrito a eliminar)
        $carrito->eliminar();
        // $aResultado["err"]= EXIT_SUCCESS;;
        return redirect()->to('carrito')->send();
    }

    public function confirmar(Request $request){


        $carrito = new Carrito();
        $aProductosCarrito = $carrito->obtenerPorUsuario(Session::get("usuario_id"));


        if($request->input('txtSucursal') == null){
            $mje = "Indique la sucursal";
            $carrito = new Carrito();
            $array_carrito = $carrito->obtenerPorUsuario(Session::get("usuario_id"));
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            $total = $this->calcularTotal();
            $subtotal = $this->calcularSubtotal();
            $iva = $this->calcularTotal() - $this->calcularSubtotal();   
    
            return view('web.carrito', compact('array_carrito', 'aSucursales','total', 'subtotal', 'iva', 'mje' ));

        }else{
            $sucursal = $request->input('txtSucursal');
        }

        $carrito->fk_idcliente = $aProductosCarrito[0]->idcliente;
        //insertamos los datos requeridos del pedido en la tabla pedidos
        $pedido = new Pedido();
        $pedido->fecha = date("Y-n-j"); 
        $pedido->total = $this->calcularTotal();
        $pedido->fk_idcliente = $aProductosCarrito[0]->idcliente;
        $pedido->fk_idsucursal = $sucursal;
        $pedido->estado = "Pendiente";

        $idpedido = $pedido->insertar();

        //insertamos los productos que el usuario habia agregado al carrito en la tabla pedidos_articulos
        $articulos = new Pedido_articulo();
        foreach ($aProductosCarrito as $producto) {
           $articulos->importe = $producto->precio;
           $articulos->cantidad = $producto->cantidad;
           $articulos->fk_idproducto = $producto->fk_idproducto;
           $articulos->fk_idpedido = $idpedido;

           $articulos->insertar(); 
        }

        //eliminamos los productos del carrito
        $carrito->eliminarPorCliente();

       return redirect()->to('takeaway');

    }
}
