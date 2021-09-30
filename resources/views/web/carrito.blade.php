@extends("web.plantilla")
@section('contenido')


<!-- Content -->
<section class="container-cart mt-5" high="auto">
    <div class="container ">
        <h3 class="font-weight-bold poppins-regular text-center text-uppercase">Carrito de compras</h3>
        <hr>
    </div>

    <div class="container">

        <div class="row justfy-content-betweenn">
            <div class="col-12 col-md-7">
                <table class="table table-hover text-center">
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Quitar</th>
                    </tr>
                    @foreach($array_carrito as $carrito)
                    <tr>
                        <td><img src="/imagenes/{{ $carrito->imagen }}" alt="" class="img-thumbnail" width="150" height="130"></td>
                        <td>{{ $carrito->titulo }}</td>
                        <td>{{ $carrito->cantidad }}</td>
                        <td>
                            <form action="eliminar" method="POST">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                <input type="hidden" id="id" name="id" class="form-control" value="{{$carrito->idcarrito}}">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-12 col-md-5">
                <form action="confirmar" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="id" name="id" class="form-control" required>

                    <div class="full-box div-bordered text-center">
                        <h5 class="text-center text-uppercase bg-dark text-light" style=" padding: 10px 0;">Resumen de la orden</h5>
                        <ul class="list-group bag-details">
                            <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                Subtotal
                                <span>${{$subtotal}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                IVA
                                <span>${{$iva}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                                SELECCIONA SUCURSAL
                                <span> <select name="txtSucursal" id="sucursal" class="form-control" required>
                                        <option value="-" selected disabled>-</option>
                                        @foreach($aSucursales as $sucursal)
                                        <option value="{{$sucursal->idsucursal}}">{{$sucursal->domicilio}}</option>
                                        @endforeach

                                    </select></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold bg-dark text-light bg-gradient">
                                Total
                                <span>${{$total}}</span>
                            </li>

                        </ul>
                        <button type="button" class="btn btn-warning mt-4" name="tekaway"><a href="takeaway" class="link_none">Continuar pidiendo</a></button>
                        @if(count($array_carrito) != 0)
                        <button type="submit" class="btn btn-warning mt-4" name="btnGuardar">Confirmar orden</button>
                        @endif
                        @if($mje != " ")
                        <h5 class="text-danger mt-4">{{$mje}}</h5>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>

@endsection