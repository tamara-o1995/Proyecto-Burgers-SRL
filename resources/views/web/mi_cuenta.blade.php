@extends("web.plantilla")
@section('contenido')


<div class="container mb-5 section-home">
    <div class="row justfy-content-betweenn mt-4 mb-4">

        <div class="col-12 col-md-5">
            <form action="confirmar" method="POST">

                <input type="hidden" name="_token" value=""></input>
                <input type="hidden" id="id" name="id" class="form-control" required>

                <div class="full-box div-bordered text-center">
                    <h5 class="text-center text-uppercase bg-dark" style="color: #FFF; padding: 10px 0;">DATOS DEL CLIENTE N° {{$clienteDatos->idcliente}}</h5>
                    <ul class="list-group bag-details">
                        <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Nombre
                            <span>{{$clienteDatos->nombre}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Apellido
                            <span>{{$clienteDatos->apellido}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Celular
                            <span>{{$clienteDatos->telefono}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-uppercase poppins-regular font-weight-bold">
                            Correo
                            <span>{{$clienteDatos->correo}}</span>
                        </li>

                    </ul>

                </div>
            </form>
        </div>
        <div class="col-12 col-md-7">
            <h5 class="text-center text-uppercase bg-dark" style="color: #FFF; padding: 10px 0;">PEDIDOS ACTIVOS</h5>
            <table class="table table-hover text-center">

                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Sucursal</th>
                    <th>Estado</th>
                </tr>

                @foreach($aPedidos as $pedido)
                <tr>
                    <td>{{$pedido->fecha}}</td>
                    <td>{{$pedido->total}}</td>
                    <td>{{$pedido->nombre}}</td>
                    <td>{{$pedido->estado}}</td>
                </tr>
                 @endforeach
            </table>
        </div>
    </div>
</div>


@endsection