@extends('web.plantilla')
@section('contenido')
@section('scripts')
<script>
    globalId = '<?php echo isset($postulante->idpostulante) && $postulante->idpostulante > 0 ? $postulante->idpostulante : 0; ?>';
    <?php $globalId = isset($postulante->idpostulante) ? $postulante->idpostulante : "0"; ?>
</script>
@endsection
<section>
    <div class="banner1">
        <div class="banner-body1">
            <h1 class="text-uppercase">{{$postulante->msj}}</h1>
            <a href="#fotos" class="btn btn-warning"><i class="fas fa-hamburger fa-fw"></i> &nbsp; Ir a menú</a>
        </div>
    </div>
</section>

@endsection