<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

require app_path() . '/start/constants.php';

class Pedido_articulo extends Model
{
    protected $table = 'pedidos_articulos';
    public $timestamps = false;

    protected $fillable = [
        'idpedido_articulo', 'importe', 'cantidad', 'fk_idproducto', 'fk_idpedido'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idpedido_articulo = $request->input('id') != "0" ? $request->input('id') : $this->idpedido_articulo;
        $this->importe= $request->input('txtPendiente');
        $this->cantidad = $request->input('txtEntregado');
        $this->fk_idproducto = $request->input('lstProducto');
        $this->fk_idpedido = $request->input('lstPedido');
    }

    public function obtenerFiltrado($id)
    {
        $request = $_REQUEST;
        // $columns = array(
        //     0 => 'A.idpedido_articulo',
        //     1 => 'A.importe',
        //     2 => 'A.cantidad',
        //     3 => 'A.fk_idproducto',
        //     4 => 'A.fk_idpedido'
        // );
        $sql = "SELECT DISTINCT
                A.idpedido_articulo,
                A.cantidad,
                A.fk_idproducto,
                A.fk_idpedido,
                D.titulo,
                D.descripcion,
                D.precio,
                D.imagen
                    FROM pedidos_articulos A
                    INNER JOIN productos D ON A.fk_idproducto = D.idproducto

                WHERE    A.fk_idpedido = $id ";

        //Realiza el filtrado
        // if (!empty($request['search']['value'])) {
        //     $sql .= " AND ( A.idpedido_articulo == $id" . $request['search']['value'] . "%'";
        //     $sql .= " OR A.cantidad LIKE '%" . $request['search']['value'] . "%'";
        //     $sql .= " OR D.titulo LIKE '%" . $request['search']['value'] . "%'";
        //     $sql .= " OR D.descripcion LIKE '%" . $request['search']['value'] . "%'";
        //     $sql .= " OR D.imagen LIKE '%" . $request['search']['value'] . "%'";
        //     $sql .= " OR D.precio LIKE '%" . $request['search']['value'] . "%')";



        // }
       // $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
       

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                A.idpedido_articulo,
                A.importe,
                A.cantidad,
                A.fk_idproducto,
                A.fk_idtipoproducto  
            FROM pedidos_articulos A ORDER BY nombre";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                idpedido_articulo,
                importe,
                cantidad,
                fk_idproducto ,
                fk_idtipoproducto,

            FROM pedidos_articulos WHERE idpedido_articulo = $id";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido_articulo = $lstRetorno[0]->idpedido_articulo;
            $this-> importe= $lstRetorno[0]->importe;
            $this->cantidad = $lstRetorno[0]->cantidad;
            $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
            $this->fk_idtipoproducto = $lstRetorno[0]->fk_idtipoproducto;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE pedidos_articulos SET
            idpedido_articulo = '$this->idpedido_articulo',
            importe = '$this->importe',
            cantidad = '$this->cantidad',
            fk_idproducto = '$this->fk_idproducto',
            fk_idtipoproducto = '$this->fk_idtipoproducto'
        
            WHERE idpedido_articulo=?";

        $affected = DB::update($sql, [$this->idpedido_articulo]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos_articulos WHERE
            idpedido_articulo=?";
        $affected = DB::delete($sql, [$this->idpedido_articulo]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos_articulos (
                importe,
                cantidad,
                fk_idproducto,
                fk_idpedido
            ) VALUES (?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->importe,
            $this->cantidad,
            $this->fk_idproducto,
            $this->fk_idpedido
        ]);
        return $this->idpedido_articulo = DB::getPdo()->lastInsertId();
    }

}
