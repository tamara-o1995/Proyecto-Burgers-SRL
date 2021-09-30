<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Entidades\Sistema\Usuario;
  

    require app_path() . '/start/constants.php';

    class ControladorWebRecupero extends Controller
    {
        public function index()
        {
           return view('web.recupero-clave');
        }
    }

?>