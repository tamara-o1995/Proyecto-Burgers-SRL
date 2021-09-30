@extends('web.plantilla')
@section('contenido')
<section id="login" class="login m-t">

  <div class="container" data-aos="fade-up">

    <header class="section-header mt-5">
    <h3 class="font-weight-bold poppins-regular text-center text-uppercase">Ingresar a mi cuenta</h3>
    </header>

    <div class="row gy-4">
      <div class=" col-12 col-sm-6 offset-sm-3">
        <form action="login" method="POST" class="form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <?php
          if (isset($msg)) {
            echo '<div id = "msg"></div>';
            echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
          }
          ?>
          <div class="row gy-4">
            <div class="col-12 form-group">
              <label for="txtUsuario" class="form-label">Usuario</label>
              <input type="text" name="txtUsuario" id="txtUsuario" class="form-control">
            </div>
            <div class="col-12 form-group">
              <label for="txtClave" class="form-label">Contraseña</label>
              <input type="password" name="txtClave" id="txtClave" class="form-control">
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-login-web">Ingresar</button>
            </div>
          </div>

          <div class="text-center mt-3 mb-3">
            <a class="a-registro" href="registrate">Crear una cuenta!</a>
          </div>

</section><!-- End Contact Section -->

@endsection