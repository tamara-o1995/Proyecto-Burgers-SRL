@extends('web.plantilla')
@section('contenido')
@section('scripts')
<script>
    globalId = '<?php echo isset($postulante->idpostulante) && $postulante->idpostulante > 0 ? $postulante->idpostulante : 0; ?>';
    <?php $globalId = isset($postulante->idpostulante) ? $postulante->idpostulante : "0"; ?>
</script>
@endsection
<section >
    <div class="banner1">
        <div class="banner-body1">
            <h3 class="text-uppercase">Burguer-SRL</h3>
            <p>Los mejores Hamburguesas de la ciudad</p>
            <a href="/" class="btn btn-warning"><i class="fas fa-hamburger fa-fw"></i> &nbsp; Ir a inicio</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 lg-8">
            <div class="box mt-0" data-aos="fade-up" data-aos-delay="200">
                <h4 class="font-weight-bold text-center bg-warning">En Burger SRL nos dedicamos a cocinar las mejores hamburguesas 100% carne.<br>
                Somos una empresa dedicada a brindar el mejor servicio con calidad de primera.<br>
                Burger SRL nació hace 5 años en Tandil brindando la mejor atención al público y agregando una nueva modalidad “Take Away” para brindarte un mejor servicio. Esperamos tu pedido en nuestras sucursales.</p>
                </h4>
            </div>
        </div>
    </div>
</section>
<section id="postulante" class="section-home">
    <div class="col-12">
        <div class="h5">
            <p class="h1 text-uppercase font-weight-bold">Trabajá en Burger</p>
            <h4>¡Sumate a nuestro equipo, te estamos esperando!</h4>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <form id="form1" action="postular" method="POST" enctype="multipart/form-data">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-6 mt-4">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                        <div class="form-group my-3">
                            <label>Nombre: </label>
                            <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{ $postulacion->nombre or '' }}" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Apellido: </label>
                            <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="{{ $postulacion->apellido or '' }}" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Correo:</label>
                            <input type="text" id="txtCorreo" name="txtCorreo" class="form-control" value="{{ $postulacion->correo or '' }}" required>
                        </div>
                        <div class="form-group my-3">
                            <label>WhatsApp:</label>
                            <input type="text" id="txtWhatsapp" name="txtWhatsapp" class="form-control" value="{{ $postulacion->whatsapp or '' }}" required>
                        </div>
                        <div class="form-group my-3">
                            <label>Adjunto Cv: </label>
                            <input type="file" id="txtAdjuntoCv" name="txtAdjuntoCv" class="form-control" value="{{ $postulacion->adjuntoCv or '' }}" required>
                        </div>
                        <div class="text-center mb-5">

                            <button type="submit" class="btn btn-infor mt-4"><i class="far fa-paper-plane"></i> &nbsp; ENVIAR</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</section>
@endsection