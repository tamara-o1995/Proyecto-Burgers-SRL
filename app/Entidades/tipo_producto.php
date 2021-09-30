<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipo_productos';
    public $timestamps = false;

    protected $fillable = [
        'idtipoproducto', 'nombre'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idtipoproducto = $request->input('id') != "0" ? $request->input('id') : $this->idtipoproducto;
        $this->nombre = $request->input('txtNombre');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idtipoproducto,
                  A.nombre
                FROM tipo_productos A ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idTipoProducto)
    {
        $sql = "SELECT
                idtipoproducto,
                nombre
                FROM tipo_productos WHERE idtipoproducto = $idTipoProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idtipoproducto = $lstRetorno[0]->idtipoproducto;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE tipo_productos SET
            nombre='$this->nombre'
            WHERE idtipoproducto=?";
        $affected = DB::update($sql, [$this->idtipoproducto]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM tipo_productos WHERE
            idtipoproducto=?";
        $affected = DB::delete($sql, [$this->idtipoproducto]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO tipo_productos (
                nombre
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombre
        ]);
        return $this->idtipoproducto = DB::getPdo()->lastInsertId();
    }
}