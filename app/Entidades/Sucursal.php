<?php

namespace App\Entidades;
use DB;
use Illuminate\Database\Eloquent\Model;


class Sucursal extends Model
{
    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = [
        'idsucursal', 'nombre', 'domicilio', 'celular', 'link_gmap'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
        $this->nombre = $request->input('txtNombre');
        $this->domicilio = $request->input('txtDomicilio');
        $this->celular = $request->input('txtCelular');
        $this->link_gmap = $request->input('txtlink_gmap');
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
          
            0 => 'A.nombre',
            1 => 'A.domicilio',
            2 => 'A.celular',
            3 => 'A.link_gmap'
        );
        $sql = "SELECT DISTINCT
                    A.idsucursal,
                    A.nombre,
                    A.domicilio,
                    A.celular,
                    A.link_gmap
                    FROM sucursales A
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.domicilio LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.celular LIKE '%" . $request['search']['value'] . "%'";
            $sql .= " OR A.link_gmap LIKE '%" . $request['search']['value'] . "%')";
        } 
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
       
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos()
    {
        $sql = "SELECT 
                    A.idsucursal,
                    A.nombre,
                    A.domicilio,
                    A.celular,
                    A.link_gmap
            FROM sucursales A ORDER BY domicilio";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idSucursal)
    {
        $sql = "SELECT
                    idsucursal,
                    nombre,
                    domicilio,
                    celular,
                    link_gmap
              FROM sucursales WHERE idSucursal";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idsucursal = $lstRetorno[0]->idsucursal;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->domicilio = $lstRetorno[0]->domicilio;
            $this->celular = $lstRetorno[0]->celular;
            $this->link_gmap = $lstRetorno[0]->link_gmap;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE sucursales SET
        
            nombre = '$this->nombre',
            domicilio = '$this->domicilio',
            celular = '$this->celular',
            link_gmap = '$this->link_gmap'
            WHERE idsucursal=?";
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM sucursales WHERE idsucursal=?";
        $affected = DB::delete($sql, [$this->idsucursal]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO sucursales (
            
                nombre, 
                domicilio,
                celular,
                link_gmap
            ) VALUES (?, ?, ?, ?, ?);";

        $result = DB::insert($sql, [
         
     
            $this->nombre,
            $this->domicilio,
            $this->celular,
            $this->link_gmap
        ]);
        return $this->idsucursal = DB::getPdo()->lastInsertId();
    }
}
