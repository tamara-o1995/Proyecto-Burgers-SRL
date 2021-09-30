<?php
namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [
        'idcarrito', 'fk_idproducto', 'cantidad', 'fk_idcliente'
    ];

    protected $hidden = [];

    public function obtenerPorUsuario($idUsuario)
    {
        $sql = "SELECT
                    A.idcarrito,
                    A.fk_idproducto,
                    A.cantidad,
                    A.fk_idcliente,
                    B.idcliente,
                    C.titulo,
                    C.imagen,
                    C.precio,
                    C.descripcion
         FROM carritos A
         INNER JOIN clientes B ON A.fk_idcliente = B.idcliente
         INNER JOIN productos C ON A.fk_idproducto = C.idproducto
         WHERE B.fk_idusuario = $idUsuario";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function cargarDesdeRequest($request){
        
        $this->cantidad = $request->input('txtCantidad');
        $this->fk_idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        //$this->fk_idcliente = $request->put('txtCantidad');
      
       


    }

    public function insertar()
    {
        $sql = "INSERT INTO carritos (
                   
                    cantidad,
                    fk_idproducto,
                    fk_idcliente

            ) VALUES (?,?,?);";
        $result = DB::insert($sql, [

            $this->cantidad,
            $this->fk_idproducto,
            $this->fk_idcliente
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }

    public function eliminar()
    {
        $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
        $affected = DB::delete($sql, [$this->idcarrito]);
    }

    public function eliminarPorCliente()
    {
        $sql = "DELETE FROM carritos WHERE
            fk_idcliente=?";
        $affected = DB::delete($sql, [$this->fk_idcliente]);
    }
}
