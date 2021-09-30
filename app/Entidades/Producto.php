<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
        'idproducto', 'titulo', 'descripcion', 'precio', 'imagen'
    ];

    protected $hidden = [];
   
    public function cargarDesdeRequest($request)
    {   
        $this->idproducto = $request->input('id') != "0" ? $request->input('id') : $this->idproducto;
        $this->titulo = $request->input('txtTitulo');
        $this->descripcion = $request->input('txtDescripcion');
        $this->precio = $request->input('txtPrecio');
        $this->imagen = $request->input('txtImagen');
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idproducto',
            1 => 'A.titulo',
            2 => 'A.descripcion',
            3 => 'A.precio',
            4 => 'A.imagen'

        );
        $sql = "SELECT DISTINCT
                    A.idproducto,
                    A.titulo,
                    A.descripcion,
                    A.precio,
                    A.imagen
                    FROM productos A
                WHERE 1=1
                ";


        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.titulo LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.descripcion LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.precio LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.imagen LIKE '%" . $request['search']['value'] . "%')";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                    A.idproducto,
                    A.titulo,
                    A.descripcion,
                    A.precio,
                    A.imagen

         FROM productos A ORDER BY titulo";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorId($idProducto)
    {
        $sql = "SELECT
                    idproducto,
                    titulo,
                    descripcion,
                    precio,
                    imagen
                FROM productos WHERE idproducto = $idProducto";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idproducto = $lstRetorno[0]->idproducto;
            $this->titulo = $lstRetorno[0]->titulo;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->precio = $lstRetorno[0]->precio;
            $this->imagen = $lstRetorno[0]->imagen;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE productos SET
            idproducto = '$this->idproducto',
            titulo = '$this->titulo',
            descripcion = '$this->descripcion',
            precio = '$this->precio',
            imagen = '$this->imagen'
            WHERE idproducto=?";

        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO productos (
                    idproducto,
                    titulo,
                    descripcion,
                    precio,
                    imagen
            ) VALUES (?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [

            $this->idproducto,
            $this->titulo,
            $this->descripcion,
            $this->precio,
            $this->imagen
        ]);
        return $this->idproducto = DB::getPdo()->lastInsertId();
    }
}
