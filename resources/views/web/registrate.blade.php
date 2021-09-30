@extends("web.plantilla")
@section('scripts')
<script>
    globalId = '<?php echo isset($postulante->idpostulante) && $postulante->idpostulante > 0 ? $postulante->idpostulante : 0; ?>';
    <?php $globalId = isset($postulante->idpostulante) ? $postulante->idpostulante : "0"; ?>
</script>
@endsection
@section('contenido')


<section id="postulante" class="section-home">
    <div class="col-12 mt-5">
        <div class="h5">
            <h3 class="font-weight-bold poppins-regular text-center text-uppercase">Crea tu cuenta</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="registrar" id="form1" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-6 mt-4">
                        <div class="form-group my-3">
                            <label>Usuario:</label>
                            <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Nombre: </label>
                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Apellido: </label>
                            <input type="text" id="txtApellido" name="txtApellido" class="form-control" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Correo:</label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" required>
                        </div>

                        <div class="form-group my-3">
                            <label>Contraseña: </label>
                            <input type="text" id="txtClave" name="txtClave" class="form-control" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Repetir contraseña: </label>
                            <input type="text" id="txtClave2" name="txtClave2" class="form-control" required>
                        </div>
                        <div class="text-center mb-5">

                            <button type="submit" class="btn btn-infor mt-4"><i class="far fa-paper-plane"></i> &nbsp; REGISTRARME</button>

                        </div>

                        @if($mje != " ")
                        <div class="text-center mb-5">
                            <h5 class="text-danger mt-4">{{$mje}}</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


</section>

@endsection