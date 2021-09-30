<?php
namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use Session;


class ControladorWebMi_cuenta extends Controller
{
    public function index()
    {
        $cliente = new Cliente();
        $clienteDatos = $cliente->obtenerClientePorUsuario(Session::get("usuario_id"));

        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPorCliente($clienteDatos->idcliente);

        return view('web.mi_cuenta', compact('clienteDatos', 'aPedidos'));

    }


}
?>