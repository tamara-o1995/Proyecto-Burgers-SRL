<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;

use DB;


class Pedido extends Model
{
    protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [
        'idpedido', 'fecha', 'total', 'fk_idcliente', 'fk_idsucursal', 'estado'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fecha = $request->input('txtFecha');

        $this->total = $request->input('txtTotal');
        $this->fk_idcliente = $request->input('lstCliente');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->estado = $request->input('txtEstado');
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpedido',
            1 => 'A.fecha',
            2 => 'A.total',
            3 => 'A.fk_idcliente',
            4 => 'A.fk_idsucursal',
            5 => 'A.estado'
        );
        $sql = "SELECT DISTINCT
            A.idpedido,
            A.fecha,
            A.total,
            A.fk_idcliente,
            A.fk_idsucursal,
            A.estado,
            B.nombre,
            B.apellido,
            B.telefono,
            D.domicilio


                    FROM pedidos A
                    INNER JOIN clientes B ON  A.fk_idcliente = B.idcliente
                    INNER JOIN sucursales D ON  A.fk_idsucursal = D.idsucursal
                    
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.idpedido LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR D.domicilio LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR B.nombre LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR B.telefono LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.fecha LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.total LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.estado LIKE '%" . $request['search']['value'] . "%')";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
             A.idpedido,
             A.fecha,
             A.total,
             A.fk_idcliente,
             A.fk_idsucursal,
             A.estado
            FROM pedidos A ORDER BY fecha";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedido)
    {
        $sql = "SELECT 
             idpedido,
             fecha,
             total,
             fk_idcliente,
             fk_idsucursal,
             estado
         FROM pedidos WHERE idpedido = $idPedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->total = $lstRetorno[0]->total;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->estado = $lstRetorno[0]->estado;

            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE pedidos SET
            -- idpedido = '$this->idpedido',
            -- fecha = '$this->fecha',
            -- total = '$this->total',
            -- fk_idcliente = '$this->fk_idcliente',
            -- fk_idsucursal = '$this->fk_idsucursal',
            estado = '$this->estado'
            WHERE idpedido=?";

        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos (
             
                fecha,
                total,
                fk_idcliente,
                fk_idsucursal,
                estado
               
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [

            $this->fecha,
            $this->total,
            $this->fk_idcliente,
            $this->fk_idsucursal,
            $this->estado

        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }
    public function obtenerPorCliente($id)
    {
        $sql = "SELECT 
        P.idpedido,
        P.fecha,
        P.total,
        P.fk_idcliente,
        P.fk_idsucursal,
        P.estado,
        S.nombre
    FROM pedidos P
    INNER JOIN sucursales S ON  P.fk_idsucursal = S.idsucursal
     WHERE P.fk_idcliente = $id AND (P.estado LIKE 'Pendiente' OR P.estado LIKE 'Confirmado')";
        
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
