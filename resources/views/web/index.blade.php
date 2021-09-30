@extends("web.plantilla")
@section('contenido')

<section class="section-home">
    <div class="banner">
        <div class="banner-body">
            <h1 class="text-uppercase font-weight-bold text-warning">Bienvenido a Burguers SRL</h1>
            <p>Las mejores hamburguesas y la mejor calidad la encontras en Burguers SRL</p>
            <a href="takeaway" class="btn btn-warning"><i class="fas fa-hamburger fa-fw"></i> &nbsp; Combos</a>
        </div>
    </div>

    <div class="multi py-1">
        <div class="row web-page">
            <div class="col-12 col-sm-6 pl-0">
                <div class="position-relative d-none d-md-block">
                    <img class="img-fluid" src="web/assets/img/multimedia.normal.8524e40780c8cc55.4d6f7374617a6120646573656d626172636120656e204176656e6964612050655f6e6f726d616c2e6a7067.jpg" alt="nombre_platillo">
                </div>
            </div>
            <div class="col-12 col-sm-6 text-center pl-0">
                <div class="text-center">
                    <h2 class="text-center text-uppercase poppins-regular font-weight-bold">La reunión perfecta si existe</h2>
                    <p class="mt-4 text-center poppins-regular font-weight-bold">Registrate y hace tu pedido</p>
                    <i class="fas fa-angle-double-down"></i>
                </div>

                <div class="div-take text-center">
                    <a href="registrate"><img src="web/assets/img/silueta-de-logotipo-de-logotipo-de-comida-de-hamburguesa.png" alt="texto" class="logo-burger1"></a>
                </div>
            </div>

        </div>
    </div>

    <div class="sucursales1 row pt-sm-3">

        <h2 class="text-center font-weight-bold bg-warning"><i class="fas fa-map-marked-alt"></i> SUCURSALES</h2>

        <div class="sucur row justify-content-center text-center">
            @foreach ($aSucursales as $sucursal)
            <div class="sucursales col-12 col-sm text-center p-3">

                <div class="col-ms-4 text-center">
                    <h3 class="font-weight-bold bg-warning p-1">{{$sucursal->nombre}}</h3>
                    <h5>{{$sucursal->domicilio}}</h5>
                    <h5>Lunes a Domingos <br>12:00 a 00.00 </h5>
                    <h5><a href="tel:{{$sucursal->celular}}" class="telefono">{{$sucursal->celular}}</a></h5>
                </div>

                <div class="btn-sucursal col-ms-4 text-center">
                    <!-- <div class="col-6  text-center"> -->
                        <a href="{{$sucursal->link_gmap}}" class="btn-rojo  btn font-weight-bold text-white" target="_blank">Ver ubicación</a>
                    <!-- </div> -->
                </div>
            </div>
            @endforeach

        </div>
    </div>
    </div>
</section>

@endsection