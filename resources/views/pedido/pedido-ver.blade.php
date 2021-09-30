@extends('plantilla')
@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection

<!-- BARRA MENU -->

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
    <!-- <li class="breadcrumb-item active">Modificar</li> -->
</ol>
<ol class="toolbar">
    <!-- <li class="btn-item"><a title="Nuevo" href="/admin/pedido-ver" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li> -->
    <li class="btn-item"><a title="Guardar" href="#" class="fas fa-save" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    <!-- @if($globalId > 0)
    <li class="btn-item"><a title="eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a>
    </li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li> -->
</ol>
<script>
    function fsalir() {
        location.href = "/admin/pedidos";
    }
</script>
@endsection


<!-- LISTA DE PRODUCTOS Y SELECT (FORM) DE ESTADO -->

@section('contenido')

<!-- LISTA DE PRODUCTOS QUE CONTIENE EL PEDIDO -->

<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="pedido" class="display text-center">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>


        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < count($aArticulos); $i++) <tr>
            <th><img class="img-thumbnail" width="150" height="130" src="/imagenes/{{$aArticulos[$i]->imagen}}"></th>
            <th>{{$aArticulos[$i]->titulo}}</th>
            <th>{{$aArticulos[$i]->descripcion}}</th>
            <th>{{$aArticulos[$i]->cantidad}}</th>
            <th>{{$aArticulos[$i]->precio}}</th>


            </tr>
            @endfor
    </tbody>

</table>




<!-- FORMULARIO SELECT PARA EDITAR EL ESTADO -->

<form id="form1" method="POST">

    <div class="row mt-5">

        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>

        <div class="form-group col-lg-6">
            <label for="estado">Estado de pedido: {{$pedido->estado}}</label>
            <select name="txtEstado" id="estado" class="form-control" required>
                <option  value="{{ $pedido->estado }}">{{ $pedido->estado }}</option>
                <option  value="Pendiente">Pendiente</option>
                <option  value="Confirmado">Confirmado</option>
                <option  value="Cancelado">Cancelado</option>
                <option  value="Entregado">Entregado</option>
            </select>

        </div> 

    </div>
</form>
<div class="row mt-3 justify-content-end mr-4">
    <h5 class="font-weight-bold bg-warning text-end p-2">Total: ${{$pedido->total}}</h5>
</div>

<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/producto/eliminar') }}",
            data: {
                id: globalId
            },
            async: true,
            dataType: "json",
            success: function(data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
      
    }
</script>


    @endsection