@extends("web.plantilla")
@section('scripts')
<script>
    globalId = '<?php echo isset($producto->idproducto) && $producto->idproducto > 0 ? $producto->idproducto : 0; ?>';
    <?php $globalId = isset($producto->idproducto) ? $producto->idproducto : "0"; ?>
</script>
@endsection
@section('contenido')


<section class="multiTake " id="fotos">
    <div class="row web-page mt-3">
        <h3 class="font-weight-bold poppins-regular text-center text-uppercase">Elegí tu combo</h3>
    </div>
    <div class="row web-page">

        <div class="col-12 container-cards full-box" style="padding-bottom: 80px; padding-left: 25px;
    padding-right: 25px;">
            @foreach($array_productos as $producto)
            <div class="card-product div-bordered bg-white shadow-5">
                <form action="agregar/{{$producto->idproducto}}" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id" name="id" class="form-control" value="{{$producto->idproducto}}" required>
                    <figure class="card-product-img">
                        <img class="img-fluid" src="/imagenes/{{$producto->imagen}}" alt="nombre_platillo">
                    </figure>
                    <div class="card-product-body">
                        <div class="card-product-content">
                            <h5 class="fw-bolder">{{$producto->descripcion}}</h5>
                            <h3 class="card-product-price fw-bolder">${{$producto->precio}}</h3>
                        </div>
                        <div class="text-center card-product-options" style="padding: 10px 0;">

                            <label class="mt-2" for="txtCantidad">Cantidad</label>
                            <input class="agregar-option mt-1" type="number" name="txtCantidad" min="1" pattern="^[0-9]+"></input>

                            @if(Session::get('usuario_id') && Session::get('usuario_id') > 0)
                            <button type="submit" class="agregar-option btn btn-warning btn-center mt-1"><i class="fas fa-shopping-bag fa-fw"></i>&nbsp; Agregar</button>
                            @else
                            <button class="agregar-option btn btn-warning btn-center mt-1"><i class="fas fa-shopping-bag fa-fw"></i>&nbsp;<a href="login" class="link_none"> Agregar</a></button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            @endforeach
        </div>

    </div>
</section>







@endsection